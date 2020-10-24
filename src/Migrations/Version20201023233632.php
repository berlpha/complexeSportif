<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201023233632 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, hall_id INT DEFAULT NULL, field_id INT DEFAULT NULL, begin_at DATETIME NOT NULL, end_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, price_total DOUBLE PRECISION NOT NULL, type VARCHAR(25) NOT NULL, INDEX IDX_E00CEDDE52AFCFD6 (hall_id), INDEX IDX_E00CEDDE443707B0 (field_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_lesson (booking_id INT NOT NULL, lesson_id INT NOT NULL, INDEX IDX_43EE4F0D3301C60 (booking_id), INDEX IDX_43EE4F0DCDF80196 (lesson_id), PRIMARY KEY(booking_id, lesson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_member (booking_id INT NOT NULL, member_id INT NOT NULL, INDEX IDX_CB7EC1863301C60 (booking_id), INDEX IDX_CB7EC1867597D3FE (member_id), PRIMARY KEY(booking_id, member_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email_address VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field (id INT AUTO_INCREMENT NOT NULL, club_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, capacity INT NOT NULL, price_hour DOUBLE PRECISION NOT NULL, INDEX IDX_5BF5455861190A32 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hall (id INT AUTO_INCREMENT NOT NULL, club_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, capacity INT NOT NULL, price_hour DOUBLE PRECISION NOT NULL, INDEX IDX_1B8FA83F61190A32 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, amount DOUBLE PRECISION NOT NULL, currency VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, url_picture VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson_coach (lesson_id INT NOT NULL, coach_id INT NOT NULL, INDEX IDX_75BFB94BCDF80196 (lesson_id), INDEX IDX_75BFB94B3C105691 (coach_id), PRIMARY KEY(lesson_id, coach_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nursery (id INT AUTO_INCREMENT NOT NULL, name_child VARCHAR(25) NOT NULL, first_name VARCHAR(25) NOT NULL, date_custody DATETIME NOT NULL, total_price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, member_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, finished_at DATETIME NOT NULL, INDEX IDX_A3C664D37597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription_lesson (subscription_id INT NOT NULL, lesson_id INT NOT NULL, INDEX IDX_31826C749A1887DC (subscription_id), INDEX IDX_31826C74CDF80196 (lesson_id), PRIMARY KEY(subscription_id, lesson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE toto (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, username VARCHAR(255) NOT NULL, email_address VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, activate_token VARCHAR(255) DEFAULT NULL, reset_token VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649B08E074E (email_address), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_nursery (member_id INT NOT NULL, nursery_id INT NOT NULL, INDEX IDX_22AAA4DA7597D3FE (member_id), INDEX IDX_22AAA4DAF1795806 (nursery_id), PRIMARY KEY(member_id, nursery_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE52AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE443707B0 FOREIGN KEY (field_id) REFERENCES field (id)');
        $this->addSql('ALTER TABLE booking_lesson ADD CONSTRAINT FK_43EE4F0D3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_lesson ADD CONSTRAINT FK_43EE4F0DCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_member ADD CONSTRAINT FK_CB7EC1863301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_member ADD CONSTRAINT FK_CB7EC1867597D3FE FOREIGN KEY (member_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE field ADD CONSTRAINT FK_5BF5455861190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE hall ADD CONSTRAINT FK_1B8FA83F61190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE lesson_coach ADD CONSTRAINT FK_75BFB94BCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_coach ADD CONSTRAINT FK_75BFB94B3C105691 FOREIGN KEY (coach_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D37597D3FE FOREIGN KEY (member_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE subscription_lesson ADD CONSTRAINT FK_31826C749A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subscription_lesson ADD CONSTRAINT FK_31826C74CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_nursery ADD CONSTRAINT FK_22AAA4DA7597D3FE FOREIGN KEY (member_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_nursery ADD CONSTRAINT FK_22AAA4DAF1795806 FOREIGN KEY (nursery_id) REFERENCES nursery (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_lesson DROP FOREIGN KEY FK_43EE4F0D3301C60');
        $this->addSql('ALTER TABLE booking_member DROP FOREIGN KEY FK_CB7EC1863301C60');
        $this->addSql('ALTER TABLE field DROP FOREIGN KEY FK_5BF5455861190A32');
        $this->addSql('ALTER TABLE hall DROP FOREIGN KEY FK_1B8FA83F61190A32');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE443707B0');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE52AFCFD6');
        $this->addSql('ALTER TABLE booking_lesson DROP FOREIGN KEY FK_43EE4F0DCDF80196');
        $this->addSql('ALTER TABLE lesson_coach DROP FOREIGN KEY FK_75BFB94BCDF80196');
        $this->addSql('ALTER TABLE subscription_lesson DROP FOREIGN KEY FK_31826C74CDF80196');
        $this->addSql('ALTER TABLE member_nursery DROP FOREIGN KEY FK_22AAA4DAF1795806');
        $this->addSql('ALTER TABLE subscription_lesson DROP FOREIGN KEY FK_31826C749A1887DC');
        $this->addSql('ALTER TABLE booking_member DROP FOREIGN KEY FK_CB7EC1867597D3FE');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE lesson_coach DROP FOREIGN KEY FK_75BFB94B3C105691');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D37597D3FE');
        $this->addSql('ALTER TABLE member_nursery DROP FOREIGN KEY FK_22AAA4DA7597D3FE');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_lesson');
        $this->addSql('DROP TABLE booking_member');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE field');
        $this->addSql('DROP TABLE hall');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE lesson_coach');
        $this->addSql('DROP TABLE nursery');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE subscription_lesson');
        $this->addSql('DROP TABLE toto');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE member_nursery');
    }
}
