<?php

declare(strict_types=1);

namespace Frago9876543210\BlocksConverter;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Blocks{
	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		if($sender instanceof Player){
			foreach($sender->level->getChunks() as $chunk){
				foreach($chunk->getSubChunks() as $subChunk){
					for($x = 0; $x < 16; $x++){
						for($y = 0; $y < 16; $y++){
							for($z = 0; $z < 16; $z++){
								$id = $subChunk->getBlockId($x, $y, $z);
								if(in_array($id, array_keys(self::IDS))){
									$subChunk->setBlock($x, $y, $z, self::IDS[$id], $subChunk->getBlockData($x, $y, $z));
								}
							}
						}
					}
				}
				$chunk->setChanged(true);
				$sender->sendMessage(TextFormat::AQUA . "Changed chunk " . $chunk->getX() . " " . $chunk->getZ());
			}
			$sender->level->save(true);
			$sender->sendMessage(TextFormat::GREEN . "World \"" . $sender->level->getName() . "\" was saved!");
			sleep(3);
			$this->getServer()->shutdown();
		}
		return true;
	}
}