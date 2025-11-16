<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251116164459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pet_pet_breed (pet_id INT NOT NULL, pet_breed_id INT NOT NULL, PRIMARY KEY(pet_id, pet_breed_id))');
        $this->addSql('CREATE INDEX IDX_B04F81E8966F7FB6 ON pet_pet_breed (pet_id)');
        $this->addSql('CREATE INDEX IDX_B04F81E8E1C3AAC2 ON pet_pet_breed (pet_breed_id)');
        $this->addSql('ALTER TABLE pet_pet_breed ADD CONSTRAINT FK_B04F81E8966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pet_pet_breed ADD CONSTRAINT FK_B04F81E8E1C3AAC2 FOREIGN KEY (pet_breed_id) REFERENCES pet_breed (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pet DROP CONSTRAINT fk_e4529b85a8b4a30f');
        $this->addSql('DROP INDEX idx_e4529b85a8b4a30f');
        $this->addSql('ALTER TABLE pet DROP breed_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pet_pet_breed DROP CONSTRAINT FK_B04F81E8966F7FB6');
        $this->addSql('ALTER TABLE pet_pet_breed DROP CONSTRAINT FK_B04F81E8E1C3AAC2');
        $this->addSql('DROP TABLE pet_pet_breed');
        $this->addSql('ALTER TABLE pet ADD breed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT fk_e4529b85a8b4a30f FOREIGN KEY (breed_id) REFERENCES pet_breed (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_e4529b85a8b4a30f ON pet (breed_id)');
    }
}
