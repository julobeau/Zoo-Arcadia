<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240429083901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rapport_veterinaire_habitat (id INT AUTO_INCREMENT NOT NULL, habitat_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', etat VARCHAR(255) NOT NULL, rapport LONGTEXT DEFAULT NULL, INDEX IDX_644FD183AFFE2D26 (habitat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rapport_veterinaire_habitat ADD CONSTRAINT FK_644FD183AFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport_veterinaire_habitat DROP FOREIGN KEY FK_644FD183AFFE2D26');
        $this->addSql('DROP TABLE rapport_veterinaire_habitat');
    }
}
