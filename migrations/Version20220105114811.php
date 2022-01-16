<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220105114811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contributions (id INT AUTO_INCREMENT NOT NULL, paymentmodes_id INT DEFAULT NULL, tid VARCHAR(10) NOT NULL, amount VARCHAR(10) NOT NULL, period VARCHAR(50) NOT NULL, status VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, validated_at DATETIME NOT NULL, validatedby VARCHAR(10) DEFAULT NULL, INDEX IDX_76391EFE1C0E1FB9 (paymentmodes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contributions ADD CONSTRAINT FK_76391EFE1C0E1FB9 FOREIGN KEY (paymentmodes_id) REFERENCES paymentmodes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contributions');
    }
}
