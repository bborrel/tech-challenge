<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251115202917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pet (id SERIAL NOT NULL, type_id INT NOT NULL, breed_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, date_of_birth DATE DEFAULT NULL, approximate_age DOUBLE PRECISION DEFAULT NULL, date_of_age_approximation DATE DEFAULT NULL, sex VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E4529B85C54C8C93 ON pet (type_id)');
        $this->addSql('CREATE INDEX IDX_E4529B85A8B4A30F ON pet (breed_id)');
        $this->addSql('CREATE TABLE pet_breed (id SERIAL NOT NULL, type_id INT NOT NULL, name VARCHAR(255) NOT NULL, is_dangerous BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_55D348ECC54C8C93 ON pet_breed (type_id)');
        $this->addSql('CREATE TABLE pet_type (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B85C54C8C93 FOREIGN KEY (type_id) REFERENCES pet_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B85A8B4A30F FOREIGN KEY (breed_id) REFERENCES pet_breed (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pet_breed ADD CONSTRAINT FK_55D348ECC54C8C93 FOREIGN KEY (type_id) REFERENCES pet_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pet DROP CONSTRAINT FK_E4529B85C54C8C93');
        $this->addSql('ALTER TABLE pet DROP CONSTRAINT FK_E4529B85A8B4A30F');
        $this->addSql('ALTER TABLE pet_breed DROP CONSTRAINT FK_55D348ECC54C8C93');
        $this->addSql('DROP TABLE pet');
        $this->addSql('DROP TABLE pet_breed');
        $this->addSql('DROP TABLE pet_type');
    }
}
