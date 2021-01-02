<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210102182403 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clue ADD scene_id INT NOT NULL');
        $this->addSql('ALTER TABLE clue ADD CONSTRAINT FK_268AADD1166053B4 FOREIGN KEY (scene_id) REFERENCES scene (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_268AADD1166053B4 ON clue (scene_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clue DROP FOREIGN KEY FK_268AADD1166053B4');
        $this->addSql('DROP INDEX UNIQ_268AADD1166053B4 ON clue');
        $this->addSql('ALTER TABLE clue DROP scene_id');
    }
}
