<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240528132333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FF30E54A48 FOREIGN KEY (pro_type_id) REFERENCES pro_type (id)');
        $this->addSql('CREATE INDEX IDX_3DDCB9FF30E54A48 ON programme (pro_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FF30E54A48');
        $this->addSql('DROP INDEX IDX_3DDCB9FF30E54A48 ON programme');
    }
}
