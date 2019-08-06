<?php

use yii\db\Migration;

/**
 * Class m190724_124058_users
 */
class m190724_124058_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users',[
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'regtime' => 'timestamp with time zone DEFAULT now()',
            'lastlogintime' => 'timestamp with time zone DEFAULT now()',
            'is_admin' => $this->boolean()->defaultValue(false)
        ]);

        $this->createTable('ticket',[
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'createtime' => 'timestamp with time zone',
            'is_open' => $this->boolean()->defaultValue(true),
            'user_id' => $this->integer(),
            'admin_id' => $this->integer()
        ]);

        $this->createTable('comment',[
            'id' => $this->primaryKey(),
            'description' => $this->string()->notNull(),
            'create_time' => 'timestamp with time zone',
            'user_id' => $this->integer(),
            'ticket_id' => $this->integer()
        ]);

        $this->addForeignKey(
            'fk-ticket-userid',
            'ticket',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-ticket-adminid',
            'ticket',
            'admin_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-comment-userid',
            'comment',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-comment-ticketid',
            'comment',
            'ticket_id',
            'ticket',
            'id',
            'CASCADE',
            'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('comment');
        $this->dropTable('ticket');
        $this->dropTable('users');

    }


}
