<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200703221828 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE coach DROP FOREIGN KEY FK_3F596DCCA76ED395');
        $this->addSql('DROP INDEX IDX_3F596DCCA76ED395 ON coach');
        $this->addSql('ALTER TABLE coach DROP user_id');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA78A76ED395');
        $this->addSql('DROP INDEX IDX_70E4FA78A76ED395 ON member');
        $this->addSql('ALTER TABLE member DROP user_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE coach ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT FK_3F596DCCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3F596DCCA76ED395 ON coach (user_id)');
        $this->addSql('ALTER TABLE member ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_70E4FA78A76ED395 ON member (user_id)');
    }
}