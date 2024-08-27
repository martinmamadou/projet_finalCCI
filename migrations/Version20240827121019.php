<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240827121019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', enable TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, programme_id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, note INT NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', enable TINYINT(1) NOT NULL, INDEX IDX_D9BEC0C462BB7AEE (programme_id), INDEX IDX_D9BEC0C4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ex_template (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, gifurl VARCHAR(255) DEFAULT NULL, instruction LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercices (id INT AUTO_INCREMENT NOT NULL, programme_id INT NOT NULL, exercice_id INT NOT NULL, repetitions INT DEFAULT NULL, temps INT DEFAULT NULL, repos INT DEFAULT NULL, INDEX IDX_1387EAE162BB7AEE (programme_id), INDEX IDX_1387EAE189D40298 (exercice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, programme_id INT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8933C43262BB7AEE (programme_id), INDEX IDX_8933C432A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre_ex_template (membre_id INT NOT NULL, ex_template_id INT NOT NULL, INDEX IDX_E305225B6A99F74A (membre_id), INDEX IDX_E305225B19804C43 (ex_template_id), PRIMARY KEY(membre_id, ex_template_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pro_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programme (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, pro_type_id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, short_description VARCHAR(255) DEFAULT NULL, moyenne DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3DDCB9FFBCF5E72D (categorie_id), INDEX IDX_3DDCB9FF30E54A48 (pro_type_id), INDEX IDX_3DDCB9FFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, enable TINYINT(1) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_info (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, taille DOUBLE PRECISION DEFAULT NULL, poids DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_B1087D9EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C462BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE exercices ADD CONSTRAINT FK_1387EAE162BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE exercices ADD CONSTRAINT FK_1387EAE189D40298 FOREIGN KEY (exercice_id) REFERENCES ex_template (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C43262BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE membre_ex_template ADD CONSTRAINT FK_E305225B6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membre_ex_template ADD CONSTRAINT FK_E305225B19804C43 FOREIGN KEY (ex_template_id) REFERENCES ex_template (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FFBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FF30E54A48 FOREIGN KEY (pro_type_id) REFERENCES pro_type (id)');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_info ADD CONSTRAINT FK_B1087D9EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C462BB7AEE');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4A76ED395');
        $this->addSql('ALTER TABLE exercices DROP FOREIGN KEY FK_1387EAE162BB7AEE');
        $this->addSql('ALTER TABLE exercices DROP FOREIGN KEY FK_1387EAE189D40298');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C43262BB7AEE');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432A76ED395');
        $this->addSql('ALTER TABLE membre_ex_template DROP FOREIGN KEY FK_E305225B6A99F74A');
        $this->addSql('ALTER TABLE membre_ex_template DROP FOREIGN KEY FK_E305225B19804C43');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FFBCF5E72D');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FF30E54A48');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FFA76ED395');
        $this->addSql('ALTER TABLE user_info DROP FOREIGN KEY FK_B1087D9EA76ED395');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE ex_template');
        $this->addSql('DROP TABLE exercices');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE membre_ex_template');
        $this->addSql('DROP TABLE pro_type');
        $this->addSql('DROP TABLE programme');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_info');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
