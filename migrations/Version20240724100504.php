<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240724100504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre_ex_template (membre_id INT NOT NULL, ex_template_id INT NOT NULL, INDEX IDX_E305225B6A99F74A (membre_id), INDEX IDX_E305225B19804C43 (ex_template_id), PRIMARY KEY(membre_id, ex_template_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE membre_ex_template ADD CONSTRAINT FK_E305225B6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membre_ex_template ADD CONSTRAINT FK_E305225B19804C43 FOREIGN KEY (ex_template_id) REFERENCES ex_template (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre_ex_template DROP FOREIGN KEY FK_E305225B6A99F74A');
        $this->addSql('ALTER TABLE membre_ex_template DROP FOREIGN KEY FK_E305225B19804C43');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE membre_ex_template');
    }
}
