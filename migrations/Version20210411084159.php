<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210411084159 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pair DROP CONSTRAINT fk_95a1e6941cd9e7a');
        $this->addSql('DROP INDEX idx_95a1e6941cd9e7a');
        $this->addSql('ALTER TABLE pair RENAME COLUMN employer_id TO vacancy_id');
        $this->addSql('ALTER TABLE pair ADD CONSTRAINT FK_95A1E69433B78C4 FOREIGN KEY (vacancy_id) REFERENCES vacancy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_95A1E69433B78C4 ON pair (vacancy_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pair DROP CONSTRAINT FK_95A1E69433B78C4');
        $this->addSql('DROP INDEX IDX_95A1E69433B78C4');
        $this->addSql('ALTER TABLE pair RENAME COLUMN vacancy_id TO employer_id');
        $this->addSql('ALTER TABLE pair ADD CONSTRAINT fk_95a1e6941cd9e7a FOREIGN KEY (employer_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_95a1e6941cd9e7a ON pair (employer_id)');
    }
}
