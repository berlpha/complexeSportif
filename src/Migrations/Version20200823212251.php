<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200823212251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_member (booking_id INT NOT NULL, member_id INT NOT NULL, INDEX IDX_CB7EC1863301C60 (booking_id), INDEX IDX_CB7EC1867597D3FE (member_id), PRIMARY KEY(booking_id, member_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking_member ADD CONSTRAINT FK_CB7EC1863301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_member ADD CONSTRAINT FK_CB7EC1867597D3FE FOREIGN KEY (member_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE migration_versions');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE user_booking');
        $this->addSql('ALTER TABLE booking ADD type VARCHAR(25) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE migration_versions (version VARCHAR(14) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, executed_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, member_id INT DEFAULT NULL, lesson_id INT DEFAULT NULL, participate TINYINT(1) NOT NULL, date_participate DATETIME NOT NULL, INDEX IDX_AB55E24FCDF80196 (lesson_id), INDEX IDX_AB55E24F7597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_booking (user_id INT NOT NULL, booking_id INT NOT NULL, INDEX IDX_B801F3D4A76ED395 (user_id), INDEX IDX_B801F3D43301C60 (booking_id), PRIMARY KEY(user_id, booking_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F7597D3FE FOREIGN KEY (member_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('ALTER TABLE user_booking ADD CONSTRAINT FK_B801F3D43301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_booking ADD CONSTRAINT FK_B801F3D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE booking_member');
        $this->addSql('ALTER TABLE booking DROP type');
    }
}
