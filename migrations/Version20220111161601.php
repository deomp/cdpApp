<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220111161601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contributions ADD categoryfinances_id INT DEFAULT NULL, ADD createdby VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE contributions ADD CONSTRAINT FK_76391EFED7103919 FOREIGN KEY (categoryfinances_id) REFERENCES categoryfinances (id)');
        $this->addSql('CREATE INDEX IDX_76391EFED7103919 ON contributions (categoryfinances_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contributions DROP FOREIGN KEY FK_76391EFED7103919');
        $this->addSql('DROP INDEX IDX_76391EFED7103919 ON contributions');
        $this->addSql('ALTER TABLE contributions DROP categoryfinances_id, DROP createdby');
    }
}
