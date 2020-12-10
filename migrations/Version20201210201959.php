<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201210201959 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dialog ADD game_id INT NOT NULL');
        $this->addSql('ALTER TABLE dialog ADD CONSTRAINT FK_4561D862E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_4561D862E48FD905 ON dialog (game_id)');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C5E46C4E2');
        $this->addSql('DROP INDEX IDX_232B318C5E46C4E2 ON game');
        $this->addSql('ALTER TABLE game DROP dialog_id, CHANGE description game_description LONGTEXT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dialog DROP FOREIGN KEY FK_4561D862E48FD905');
        $this->addSql('DROP INDEX IDX_4561D862E48FD905 ON dialog');
        $this->addSql('ALTER TABLE dialog DROP game_id');
        $this->addSql('ALTER TABLE game ADD dialog_id INT DEFAULT NULL, CHANGE game_description description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C5E46C4E2 FOREIGN KEY (dialog_id) REFERENCES dialog (id)');
        $this->addSql('CREATE INDEX IDX_232B318C5E46C4E2 ON game (dialog_id)');
    }
}
