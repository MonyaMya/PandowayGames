<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201212194552 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE scene (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, background VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, previous_scene INT NOT NULL, dialog INT DEFAULT NULL, investigation INT DEFAULT NULL, INDEX IDX_D979EFDAE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE scene ADD CONSTRAINT FK_D979EFDAE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('DROP TABLE break_scene');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE clue DROP FOREIGN KEY FK_268AADD1E48FD905');
        $this->addSql('DROP INDEX IDX_268AADD1E48FD905 ON clue');
        $this->addSql('ALTER TABLE clue ADD name VARCHAR(255) NOT NULL, ADD letter VARCHAR(255) NOT NULL, ADD number INT NOT NULL, ADD img VARCHAR(255) NOT NULL, DROP game_id, DROP background, DROP x_axis, DROP y_axis, DROP clue_name, DROP clue_img, DROP description, DROP scene_n');
        $this->addSql('ALTER TABLE dialog DROP FOREIGN KEY FK_4561D862E48FD905');
        $this->addSql('DROP INDEX IDX_4561D862E48FD905 ON dialog');
        $this->addSql('ALTER TABLE dialog ADD img VARCHAR(255) NOT NULL, DROP game_id, DROP background, DROP character_img, DROP description, DROP scene_n');
        $this->addSql('ALTER TABLE game CHANGE game_description description LONGTEXT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE break_scene (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, background VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, scene_n INT NOT NULL, INDEX IDX_F0041584E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles JSON NOT NULL, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE break_scene ADD CONSTRAINT FK_F0041584E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('DROP TABLE scene');
        $this->addSql('ALTER TABLE clue ADD background VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD x_axis INT NOT NULL, ADD y_axis INT NOT NULL, ADD clue_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD clue_img VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD scene_n INT NOT NULL, DROP name, DROP letter, DROP img, CHANGE number game_id INT NOT NULL');
        $this->addSql('ALTER TABLE clue ADD CONSTRAINT FK_268AADD1E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_268AADD1E48FD905 ON clue (game_id)');
        $this->addSql('ALTER TABLE dialog ADD game_id INT NOT NULL, ADD character_img VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD scene_n INT NOT NULL, CHANGE img background VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE dialog ADD CONSTRAINT FK_4561D862E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_4561D862E48FD905 ON dialog (game_id)');
        $this->addSql('ALTER TABLE game CHANGE description game_description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
