<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201025001140 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrator (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coach (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT FK_3F596DCCBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_member DROP FOREIGN KEY FK_CB7EC1867597D3FE');
        $this->addSql('ALTER TABLE booking_member ADD CONSTRAINT FK_CB7EC1867597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_coach DROP FOREIGN KEY FK_75BFB94B3C105691');
        $this->addSql('ALTER TABLE lesson_coach ADD CONSTRAINT FK_75BFB94B3C105691 FOREIGN KEY (coach_id) REFERENCES coach (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_nursery DROP FOREIGN KEY FK_22AAA4DA7597D3FE');
        $this->addSql('ALTER TABLE member_nursery ADD CONSTRAINT FK_22AAA4DA7597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D37597D3FE');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D37597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson_coach DROP FOREIGN KEY FK_75BFB94B3C105691');
        $this->addSql('ALTER TABLE booking_member DROP FOREIGN KEY FK_CB7EC1867597D3FE');
        $this->addSql('ALTER TABLE member_nursery DROP FOREIGN KEY FK_22AAA4DA7597D3FE');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D37597D3FE');
        $this->addSql('DROP TABLE administrator');
        $this->addSql('DROP TABLE coach');
        $this->addSql('DROP TABLE member');
        $this->addSql('ALTER TABLE booking_member DROP FOREIGN KEY FK_CB7EC1867597D3FE');
        $this->addSql('ALTER TABLE booking_member ADD CONSTRAINT FK_CB7EC1867597D3FE FOREIGN KEY (member_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_coach DROP FOREIGN KEY FK_75BFB94B3C105691');
        $this->addSql('ALTER TABLE lesson_coach ADD CONSTRAINT FK_75BFB94B3C105691 FOREIGN KEY (coach_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_nursery DROP FOREIGN KEY FK_22AAA4DA7597D3FE');
        $this->addSql('ALTER TABLE member_nursery ADD CONSTRAINT FK_22AAA4DA7597D3FE FOREIGN KEY (member_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D37597D3FE');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D37597D3FE FOREIGN KEY (member_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
