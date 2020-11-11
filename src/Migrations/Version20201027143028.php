<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201027143028 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_member ADD CONSTRAINT FK_CB7EC1867597D3FE FOREIGN KEY (member_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_coach ADD CONSTRAINT FK_75BFB94B3C105691 FOREIGN KEY (coach_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D37597D3FE FOREIGN KEY (member_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE member_nursery ADD CONSTRAINT FK_22AAA4DA7597D3FE FOREIGN KEY (member_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_member DROP FOREIGN KEY FK_CB7EC1867597D3FE');
        $this->addSql('ALTER TABLE lesson_coach DROP FOREIGN KEY FK_75BFB94B3C105691');
        $this->addSql('ALTER TABLE member_nursery DROP FOREIGN KEY FK_22AAA4DA7597D3FE');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D37597D3FE');
    }
}
