<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201210194817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE break_scene (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, background VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, scene_n INT NOT NULL, INDEX IDX_F0041584E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clue (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, background VARCHAR(255) NOT NULL, x_axis INT NOT NULL, y_axis INT NOT NULL, clue_name VARCHAR(255) NOT NULL, clue_img VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, scene_n INT NOT NULL, INDEX IDX_268AADD1E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dialog (id INT AUTO_INCREMENT NOT NULL, background VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, character_img VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, scene_n INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE break_scene ADD CONSTRAINT FK_F0041584E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE clue ADD CONSTRAINT FK_268AADD1E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game ADD dialog_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C5E46C4E2 FOREIGN KEY (dialog_id) REFERENCES dialog (id)');
        $this->addSql('CREATE INDEX IDX_232B318C5E46C4E2 ON game (dialog_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C5E46C4E2');
        $this->addSql('DROP TABLE break_scene');
        $this->addSql('DROP TABLE clue');
        $this->addSql('DROP TABLE dialog');
        $this->addSql('DROP INDEX IDX_232B318C5E46C4E2 ON game');
        $this->addSql('ALTER TABLE game DROP dialog_id');
    }
}
