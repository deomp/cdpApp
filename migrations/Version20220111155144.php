<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220111155144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE financecategories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, month VARCHAR(50) NOT NULL, year VARCHAR(50) NOT NULL, action VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contributions ADD financecategories_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contributions ADD CONSTRAINT FK_76391EFEF40050F7 FOREIGN KEY (financecategories_id) REFERENCES financecategories (id)');
        $this->addSql('CREATE INDEX IDX_76391EFEF40050F7 ON contributions (financecategories_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contributions DROP FOREIGN KEY FK_76391EFEF40050F7');
        $this->addSql('DROP TABLE financecategories');
        $this->addSql('DROP INDEX IDX_76391EFEF40050F7 ON contributions');
        $this->addSql('ALTER TABLE contributions DROP financecategories_id');
    }
}
