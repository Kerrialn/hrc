<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210411065744 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE pair_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pair (id INT NOT NULL, candidate_id INT DEFAULT NULL, employer_id INT DEFAULT NULL, is_position_liked BOOLEAN NOT NULL, is_candidate_liked BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_95A1E6991BD8781 ON pair (candidate_id)');
        $this->addSql('CREATE INDEX IDX_95A1E6941CD9E7A ON pair (employer_id)');
        $this->addSql('ALTER TABLE pair ADD CONSTRAINT FK_95A1E6991BD8781 FOREIGN KEY (candidate_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pair ADD CONSTRAINT FK_95A1E6941CD9E7A FOREIGN KEY (employer_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE pair_id_seq CASCADE');
        $this->addSql('DROP TABLE pair');
    }
}
