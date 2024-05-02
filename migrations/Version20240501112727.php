<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240501112727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detail_exercice (id INT AUTO_INCREMENT NOT NULL, repetition INT DEFAULT NULL, temps INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_exercice_exercices (detail_exercice_id INT NOT NULL, exercices_id INT NOT NULL, INDEX IDX_94152934E6DF6FC9 (detail_exercice_id), INDEX IDX_94152934192C7251 (exercices_id), PRIMARY KEY(detail_exercice_id, exercices_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detail_exercice_exercices ADD CONSTRAINT FK_94152934E6DF6FC9 FOREIGN KEY (detail_exercice_id) REFERENCES detail_exercice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detail_exercice_exercices ADD CONSTRAINT FK_94152934192C7251 FOREIGN KEY (exercices_id) REFERENCES exercices (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_programme DROP FOREIGN KEY FK_90AC04C262BB7AEE');
        $this->addSql('DROP TABLE info_programme');
        $this->addSql('ALTER TABLE categorie ADD image_name VARCHAR(255) DEFAULT NULL, ADD image_size INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE info_programme (id INT AUTO_INCREMENT NOT NULL, programme_id INT NOT NULL, repetition INT DEFAULT NULL, temps INT DEFAULT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_90AC04C262BB7AEE (programme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE info_programme ADD CONSTRAINT FK_90AC04C262BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE detail_exercice_exercices DROP FOREIGN KEY FK_94152934E6DF6FC9');
        $this->addSql('ALTER TABLE detail_exercice_exercices DROP FOREIGN KEY FK_94152934192C7251');
        $this->addSql('DROP TABLE detail_exercice');
        $this->addSql('DROP TABLE detail_exercice_exercices');
        $this->addSql('ALTER TABLE categorie DROP image_name, DROP image_size');
    }
}
