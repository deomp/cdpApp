<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220105124225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contributions ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contributions ADD CONSTRAINT FK_76391EFE67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_76391EFE67B3B43D ON contributions (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contributions DROP FOREIGN KEY FK_76391EFE67B3B43D');
        $this->addSql('DROP INDEX IDX_76391EFE67B3B43D ON contributions');
        $this->addSql('ALTER TABLE contributions DROP users_id');
    }
}
