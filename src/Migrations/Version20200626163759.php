<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200626163759 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lesson_coach DROP FOREIGN KEY FK_75BFB94BCDF80196');
        $this->addSql('ALTER TABLE lesson_field DROP FOREIGN KEY FK_111391DFCDF80196');
        $this->addSql('ALTER TABLE lesson_hall DROP FOREIGN KEY FK_22FE6E5BCDF80196');
        $this->addSql('ALTER TABLE lesson_subscription DROP FOREIGN KEY FK_34E564B0CDF80196');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FCDF80196');
        $this->addSql('ALTER TABLE lesson_subscription DROP FOREIGN KEY FK_34E564B09A1887DC');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA789A1887DC');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE lesson_coach');
        $this->addSql('DROP TABLE lesson_field');
        $this->addSql('DROP TABLE lesson_hall');
        $this->addSql('DROP TABLE lesson_subscription');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP INDEX IDX_70E4FA789A1887DC ON member');
        $this->addSql('ALTER TABLE member DROP subscription_id');
        $this->addSql('DROP INDEX IDX_AB55E24FCDF80196 ON participation');
        $this->addSql('ALTER TABLE participation DROP lesson_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type TINYTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price DOUBLE PRECISION NOT NULL, url_picture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lesson_coach (lesson_id INT NOT NULL, coach_id INT NOT NULL, INDEX IDX_75BFB94BCDF80196 (lesson_id), INDEX IDX_75BFB94B3C105691 (coach_id), PRIMARY KEY(lesson_id, coach_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lesson_field (lesson_id INT NOT NULL, field_id INT NOT NULL, INDEX IDX_111391DFCDF80196 (lesson_id), INDEX IDX_111391DF443707B0 (field_id), PRIMARY KEY(lesson_id, field_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lesson_hall (lesson_id INT NOT NULL, hall_id INT NOT NULL, INDEX IDX_22FE6E5BCDF80196 (lesson_id), INDEX IDX_22FE6E5B52AFCFD6 (hall_id), PRIMARY KEY(lesson_id, hall_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lesson_subscription (lesson_id INT NOT NULL, subscription_id INT NOT NULL, INDEX IDX_34E564B0CDF80196 (lesson_id), INDEX IDX_34E564B09A1887DC (subscription_id), PRIMARY KEY(lesson_id, subscription_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, finished_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE lesson_coach ADD CONSTRAINT FK_75BFB94B3C105691 FOREIGN KEY (coach_id) REFERENCES coach (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_coach ADD CONSTRAINT FK_75BFB94BCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_field ADD CONSTRAINT FK_111391DF443707B0 FOREIGN KEY (field_id) REFERENCES field (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_field ADD CONSTRAINT FK_111391DFCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_hall ADD CONSTRAINT FK_22FE6E5B52AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_hall ADD CONSTRAINT FK_22FE6E5BCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_subscription ADD CONSTRAINT FK_34E564B09A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_subscription ADD CONSTRAINT FK_34E564B0CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member ADD subscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA789A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id)');
        $this->addSql('CREATE INDEX IDX_70E4FA789A1887DC ON member (subscription_id)');
        $this->addSql('ALTER TABLE participation ADD lesson_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('CREATE INDEX IDX_AB55E24FCDF80196 ON participation (lesson_id)');
    }
}
