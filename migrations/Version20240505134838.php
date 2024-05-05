<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505134838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, race_id INT NOT NULL, habitat_id INT NOT NULL, firstname VARCHAR(64) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_6AAB231F6E59D40D (race_id), INDEX IDX_6AAB231FAFFE2D26 (habitat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE food_given (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, soigneur_id INT NOT NULL, food VARCHAR(255) NOT NULL, food_quantity NUMERIC(10, 0) NOT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B883E67C8E962C16 (animal_id), INDEX IDX_B883E67CECF1F665 (soigneur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(64) NOT NULL, resume VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_animaux (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, image VARCHAR(255) NOT NULL, cover TINYINT(1) NOT NULL, INDEX IDX_5C3072F8E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_habitat (id INT AUTO_INCREMENT NOT NULL, habitat_id INT NOT NULL, image VARCHAR(255) NOT NULL, cover TINYINT(1) NOT NULL, INDEX IDX_A44AAC8AAFFE2D26 (habitat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, species VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport_veterinaire_animal (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, veterinaire_id INT DEFAULT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', rapport LONGTEXT DEFAULT NULL, etat VARCHAR(255) NOT NULL, nourriture VARCHAR(255) NOT NULL, quantite_nourriture NUMERIC(10, 2) NOT NULL, INDEX IDX_174040268E962C16 (animal_id), INDEX IDX_174040265C80924 (veterinaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport_veterinaire_habitat (id INT AUTO_INCREMENT NOT NULL, habitat_id INT NOT NULL, veterinaire_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', etat VARCHAR(255) NOT NULL, rapport LONGTEXT DEFAULT NULL, INDEX IDX_644FD183AFFE2D26 (habitat_id), INDEX IDX_644FD1835C80924 (veterinaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(100) NOT NULL, comment LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', note SMALLINT NOT NULL, is_validated TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(64) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_image (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', cover TINYINT(1) NOT NULL, INDEX IDX_6C4FE9B8ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, name VARCHAR(180) NOT NULL, firstname VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F6E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id)');
        $this->addSql('ALTER TABLE food_given ADD CONSTRAINT FK_B883E67C8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE food_given ADD CONSTRAINT FK_B883E67CECF1F665 FOREIGN KEY (soigneur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE images_animaux ADD CONSTRAINT FK_5C3072F8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE images_habitat ADD CONSTRAINT FK_A44AAC8AAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id)');
        $this->addSql('ALTER TABLE rapport_veterinaire_animal ADD CONSTRAINT FK_174040268E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE rapport_veterinaire_animal ADD CONSTRAINT FK_174040265C80924 FOREIGN KEY (veterinaire_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rapport_veterinaire_habitat ADD CONSTRAINT FK_644FD183AFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id)');
        $this->addSql('ALTER TABLE rapport_veterinaire_habitat ADD CONSTRAINT FK_644FD1835C80924 FOREIGN KEY (veterinaire_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service_image ADD CONSTRAINT FK_6C4FE9B8ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F6E59D40D');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FAFFE2D26');
        $this->addSql('ALTER TABLE food_given DROP FOREIGN KEY FK_B883E67C8E962C16');
        $this->addSql('ALTER TABLE food_given DROP FOREIGN KEY FK_B883E67CECF1F665');
        $this->addSql('ALTER TABLE images_animaux DROP FOREIGN KEY FK_5C3072F8E962C16');
        $this->addSql('ALTER TABLE images_habitat DROP FOREIGN KEY FK_A44AAC8AAFFE2D26');
        $this->addSql('ALTER TABLE rapport_veterinaire_animal DROP FOREIGN KEY FK_174040268E962C16');
        $this->addSql('ALTER TABLE rapport_veterinaire_animal DROP FOREIGN KEY FK_174040265C80924');
        $this->addSql('ALTER TABLE rapport_veterinaire_habitat DROP FOREIGN KEY FK_644FD183AFFE2D26');
        $this->addSql('ALTER TABLE rapport_veterinaire_habitat DROP FOREIGN KEY FK_644FD1835C80924');
        $this->addSql('ALTER TABLE service_image DROP FOREIGN KEY FK_6C4FE9B8ED5CA9E6');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE food_given');
        $this->addSql('DROP TABLE habitat');
        $this->addSql('DROP TABLE images_animaux');
        $this->addSql('DROP TABLE images_habitat');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE rapport_veterinaire_animal');
        $this->addSql('DROP TABLE rapport_veterinaire_habitat');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_image');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
