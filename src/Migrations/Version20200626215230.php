<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200626215230 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, url_picture VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson_hall (lesson_id INT NOT NULL, hall_id INT NOT NULL, INDEX IDX_22FE6E5BCDF80196 (lesson_id), INDEX IDX_22FE6E5B52AFCFD6 (hall_id), PRIMARY KEY(lesson_id, hall_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson_field (lesson_id INT NOT NULL, field_id INT NOT NULL, INDEX IDX_111391DFCDF80196 (lesson_id), INDEX IDX_111391DF443707B0 (field_id), PRIMARY KEY(lesson_id, field_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, type LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, finished_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription_lesson (subscription_id INT NOT NULL, lesson_id INT NOT NULL, INDEX IDX_31826C749A1887DC (subscription_id), INDEX IDX_31826C74CDF80196 (lesson_id), PRIMARY KEY(subscription_id, lesson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lesson_hall ADD CONSTRAINT FK_22FE6E5BCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_hall ADD CONSTRAINT FK_22FE6E5B52AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_field ADD CONSTRAINT FK_111391DFCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_field ADD CONSTRAINT FK_111391DF443707B0 FOREIGN KEY (field_id) REFERENCES field (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subscription_lesson ADD CONSTRAINT FK_31826C749A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subscription_lesson ADD CONSTRAINT FK_31826C74CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participation ADD lesson_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('CREATE INDEX IDX_AB55E24FCDF80196 ON participation (lesson_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FCDF80196');
        $this->addSql('ALTER TABLE lesson_hall DROP FOREIGN KEY FK_22FE6E5BCDF80196');
        $this->addSql('ALTER TABLE lesson_field DROP FOREIGN KEY FK_111391DFCDF80196');
        $this->addSql('ALTER TABLE subscription_lesson DROP FOREIGN KEY FK_31826C74CDF80196');
        $this->addSql('ALTER TABLE subscription_lesson DROP FOREIGN KEY FK_31826C749A1887DC');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE lesson_hall');
        $this->addSql('DROP TABLE lesson_field');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE subscription_lesson');
        $this->addSql('DROP INDEX IDX_AB55E24FCDF80196 ON participation');
        $this->addSql('ALTER TABLE participation DROP lesson_id');
    }
}
