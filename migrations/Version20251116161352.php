<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251116161352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pet ALTER date_of_birth TYPE DATE');
        $this->addSql('ALTER TABLE pet ALTER date_of_age_approximation TYPE DATE');
        $this->addSql('COMMENT ON COLUMN pet.date_of_birth IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN pet.date_of_age_approximation IS \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pet ALTER date_of_birth TYPE DATE');
        $this->addSql('ALTER TABLE pet ALTER date_of_age_approximation TYPE DATE');
        $this->addSql('COMMENT ON COLUMN pet.date_of_birth IS NULL');
        $this->addSql('COMMENT ON COLUMN pet.date_of_age_approximation IS NULL');
    }
}
