<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201213182546 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scene ADD game_id INT NOT NULL, CHANGE clue investigation INT DEFAULT NULL');
        $this->addSql('ALTER TABLE scene ADD CONSTRAINT FK_D979EFDAE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_D979EFDAE48FD905 ON scene (game_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scene DROP FOREIGN KEY FK_D979EFDAE48FD905');
        $this->addSql('DROP INDEX IDX_D979EFDAE48FD905 ON scene');
        $this->addSql('ALTER TABLE scene DROP game_id, CHANGE investigation clue INT DEFAULT NULL');
    }
}
