<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425191208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercices (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', enable TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercices_programme (exercices_id INT NOT NULL, programme_id INT NOT NULL, INDEX IDX_8B07F48192C7251 (exercices_id), INDEX IDX_8B07F4862BB7AEE (programme_id), PRIMARY KEY(exercices_id, programme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, short_description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', enable TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercices_programme ADD CONSTRAINT FK_8B07F48192C7251 FOREIGN KEY (exercices_id) REFERENCES exercices (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercices_programme ADD CONSTRAINT FK_8B07F4862BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercice_maison_programme_maison DROP FOREIGN KEY FK_9D8D2C73FA833B9');
        $this->addSql('ALTER TABLE exercice_maison_programme_maison DROP FOREIGN KEY FK_9D8D2C74D7D7FA1');
        $this->addSql('DROP TABLE exercice_maison');
        $this->addSql('DROP TABLE programme_maison');
        $this->addSql('DROP TABLE exercice_maison_programme_maison');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercice_maison (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', enable TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE programme_maison (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, short_description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', enable TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE exercice_maison_programme_maison (exercice_maison_id INT NOT NULL, programme_maison_id INT NOT NULL, INDEX IDX_9D8D2C73FA833B9 (exercice_maison_id), INDEX IDX_9D8D2C74D7D7FA1 (programme_maison_id), PRIMARY KEY(exercice_maison_id, programme_maison_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE exercice_maison_programme_maison ADD CONSTRAINT FK_9D8D2C73FA833B9 FOREIGN KEY (exercice_maison_id) REFERENCES exercice_maison (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercice_maison_programme_maison ADD CONSTRAINT FK_9D8D2C74D7D7FA1 FOREIGN KEY (programme_maison_id) REFERENCES programme_maison (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercices_programme DROP FOREIGN KEY FK_8B07F48192C7251');
        $this->addSql('ALTER TABLE exercices_programme DROP FOREIGN KEY FK_8B07F4862BB7AEE');
        $this->addSql('DROP TABLE exercices');
        $this->addSql('DROP TABLE exercices_programme');
        $this->addSql('DROP TABLE programme');
    }
}
