<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210416075737 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pair ADD resume_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pair ADD CONSTRAINT FK_95A1E69D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_95A1E69D262AF09 ON pair (resume_id)');
        $this->addSql('ALTER TABLE resume DROP is_default');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE resume ADD is_default BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE pair DROP CONSTRAINT FK_95A1E69D262AF09');
        $this->addSql('DROP INDEX IDX_95A1E69D262AF09');
        $this->addSql('ALTER TABLE pair DROP resume_id');
    }
}
