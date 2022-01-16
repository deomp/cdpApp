<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220105132551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contributions DROP FOREIGN KEY FK_76391EFE1C0E1FB9');
        $this->addSql('DROP INDEX IDX_76391EFE1C0E1FB9 ON contributions');
        $this->addSql('ALTER TABLE contributions ADD paymentmode VARCHAR(10) DEFAULT NULL, DROP paymentmodes_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contributions ADD paymentmodes_id INT DEFAULT NULL, DROP paymentmode');
        $this->addSql('ALTER TABLE contributions ADD CONSTRAINT FK_76391EFE1C0E1FB9 FOREIGN KEY (paymentmodes_id) REFERENCES paymentmodes (id)');
        $this->addSql('CREATE INDEX IDX_76391EFE1C0E1FB9 ON contributions (paymentmodes_id)');
    }
}
