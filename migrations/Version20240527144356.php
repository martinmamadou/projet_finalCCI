<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527144356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ex_template DROP FOREIGN KEY FK_F03300B7192C7251');
        $this->addSql('DROP INDEX IDX_F03300B7192C7251 ON ex_template');
        $this->addSql('ALTER TABLE ex_template DROP exercices_id');
        $this->addSql('ALTER TABLE exercices ADD programme_id INT NOT NULL, ADD exercice_id INT NOT NULL');
        $this->addSql('ALTER TABLE exercices ADD CONSTRAINT FK_1387EAE162BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE exercices ADD CONSTRAINT FK_1387EAE189D40298 FOREIGN KEY (exercice_id) REFERENCES ex_template (id)');
        $this->addSql('CREATE INDEX IDX_1387EAE162BB7AEE ON exercices (programme_id)');
        $this->addSql('CREATE INDEX IDX_1387EAE189D40298 ON exercices (exercice_id)');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FF192C7251');
        $this->addSql('DROP INDEX IDX_3DDCB9FF192C7251 ON programme');
        $this->addSql('ALTER TABLE programme DROP exercices_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ex_template ADD exercices_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ex_template ADD CONSTRAINT FK_F03300B7192C7251 FOREIGN KEY (exercices_id) REFERENCES exercices (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F03300B7192C7251 ON ex_template (exercices_id)');
        $this->addSql('ALTER TABLE programme ADD exercices_id INT NOT NULL');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FF192C7251 FOREIGN KEY (exercices_id) REFERENCES exercices (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3DDCB9FF192C7251 ON programme (exercices_id)');
        $this->addSql('ALTER TABLE exercices DROP FOREIGN KEY FK_1387EAE162BB7AEE');
        $this->addSql('ALTER TABLE exercices DROP FOREIGN KEY FK_1387EAE189D40298');
        $this->addSql('DROP INDEX IDX_1387EAE162BB7AEE ON exercices');
        $this->addSql('DROP INDEX IDX_1387EAE189D40298 ON exercices');
        $this->addSql('ALTER TABLE exercices DROP programme_id, DROP exercice_id');
    }
}
