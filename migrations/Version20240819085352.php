<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240819085352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, programme_id INT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8933C43262BB7AEE (programme_id), INDEX IDX_8933C432A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre_ex_template (membre_id INT NOT NULL, ex_template_id INT NOT NULL, INDEX IDX_E305225B6A99F74A (membre_id), INDEX IDX_E305225B19804C43 (ex_template_id), PRIMARY KEY(membre_id, ex_template_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pro_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C43262BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE membre_ex_template ADD CONSTRAINT FK_E305225B6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membre_ex_template ADD CONSTRAINT FK_E305225B19804C43 FOREIGN KEY (ex_template_id) REFERENCES ex_template (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ex_template ADD instruction LONGTEXT NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE short_des gifurl VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE exercices ADD programme_id INT NOT NULL, ADD exercice_id INT NOT NULL');
        $this->addSql('ALTER TABLE exercices ADD CONSTRAINT FK_1387EAE162BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE exercices ADD CONSTRAINT FK_1387EAE189D40298 FOREIGN KEY (exercice_id) REFERENCES ex_template (id)');
        $this->addSql('CREATE INDEX IDX_1387EAE162BB7AEE ON exercices (programme_id)');
        $this->addSql('CREATE INDEX IDX_1387EAE189D40298 ON exercices (exercice_id)');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB2919804C43');
        $this->addSql('DROP INDEX IDX_F6B4FB2919804C43 ON membre');
        $this->addSql('ALTER TABLE membre DROP ex_template_id');
        $this->addSql('ALTER TABLE programme ADD pro_type_id INT NOT NULL, ADD user_id INT NOT NULL, ADD moyenne DOUBLE PRECISION DEFAULT NULL, DROP type');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FF30E54A48 FOREIGN KEY (pro_type_id) REFERENCES pro_type (id)');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3DDCB9FF30E54A48 ON programme (pro_type_id)');
        $this->addSql('CREATE INDEX IDX_3DDCB9FFA76ED395 ON programme (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FF30E54A48');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C43262BB7AEE');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432A76ED395');
        $this->addSql('ALTER TABLE membre_ex_template DROP FOREIGN KEY FK_E305225B6A99F74A');
        $this->addSql('ALTER TABLE membre_ex_template DROP FOREIGN KEY FK_E305225B19804C43');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE membre_ex_template');
        $this->addSql('DROP TABLE pro_type');
        $this->addSql('ALTER TABLE exercices DROP FOREIGN KEY FK_1387EAE162BB7AEE');
        $this->addSql('ALTER TABLE exercices DROP FOREIGN KEY FK_1387EAE189D40298');
        $this->addSql('DROP INDEX IDX_1387EAE162BB7AEE ON exercices');
        $this->addSql('DROP INDEX IDX_1387EAE189D40298 ON exercices');
        $this->addSql('ALTER TABLE exercices DROP programme_id, DROP exercice_id');
        $this->addSql('ALTER TABLE ex_template DROP instruction, DROP created_at, DROP updated_at, CHANGE gifurl short_des VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE membre ADD ex_template_id INT NOT NULL');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB2919804C43 FOREIGN KEY (ex_template_id) REFERENCES ex_template (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F6B4FB2919804C43 ON membre (ex_template_id)');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FFA76ED395');
        $this->addSql('DROP INDEX IDX_3DDCB9FF30E54A48 ON programme');
        $this->addSql('DROP INDEX IDX_3DDCB9FFA76ED395 ON programme');
        $this->addSql('ALTER TABLE programme ADD type VARCHAR(255) NOT NULL, DROP pro_type_id, DROP user_id, DROP moyenne');
    }
}
