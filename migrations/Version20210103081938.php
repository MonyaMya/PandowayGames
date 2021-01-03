<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210103081938 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clue (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, letter VARCHAR(255) NOT NULL, number INT NOT NULL, img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dialog (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, image_name VARCHAR(255) NOT NULL, main_color VARCHAR(255) NOT NULL, secondary_color VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, is_published TINYINT(1) NOT NULL, author VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scene (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, image_name VARCHAR(255) NOT NULL, background VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, previous_scene INT NOT NULL, dialog INT DEFAULT NULL, investigation INT DEFAULT NULL, position INT NOT NULL, INDEX IDX_D979EFDAE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE scene ADD CONSTRAINT FK_D979EFDAE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scene DROP FOREIGN KEY FK_D979EFDAE48FD905');
        $this->addSql('DROP TABLE clue');
        $this->addSql('DROP TABLE dialog');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE scene');
        $this->addSql('DROP TABLE user');
    }
}
