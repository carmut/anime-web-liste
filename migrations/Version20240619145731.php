<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619145731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE anime ADD image_link VARCHAR(255) DEFAULT NULL, ADD statut VARCHAR(255) DEFAULT NULL, ADD day_episode_release DATE DEFAULT NULL, ADD hour_episode_release TIME DEFAULT NULL, DROP number_season, CHANGE genre genre JSON DEFAULT NULL, CHANGE lien lien VARCHAR(255) DEFAULT NULL, CHANGE site site VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE anime ADD number_season INT DEFAULT NULL, DROP image_link, DROP statut, DROP day_episode_release, DROP hour_episode_release, CHANGE genre genre JSON NOT NULL, CHANGE lien lien VARCHAR(255) NOT NULL, CHANGE site site VARCHAR(255) NOT NULL');
    }
}
