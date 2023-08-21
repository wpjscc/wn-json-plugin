<?php namespace Wpjscc\Json\Console;

use Winter\Storm\Console\Command;

use Wpjscc\Json\Services\Json;


class TestJson extends Command
{
    /**
     * @var string The console command name.
     */
    protected static $defaultName = 'json:testjson';

    /**
     * @var string The name and signature of this command.
     */
    protected $signature = 'json:testjson
        {--f|force : Force the operation to run and ignore production warnings and confirmation questions.}';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->output->writeln('Hello world!');

        $json = new Json();

        $json->registerDataSource('user', [
            'id' => 1,
            'name' => 'Hello User',
        ]);

        $json->registerDataSource('post', [
            'id' => 2,
            'name' => 'Hello post',
        ]);

        $json->registerDataSource('user_post', [
            "_data_source" => "user",
            "_data_structure" => [
                "id" => ":id",
                "name" => ":name",
                "post" => [
                    "_data_source" => "post",
                    "_data_structure" => [
                        "id" => ":id",
                        "name" => ":name"
                    ]
                ]
            ]
        ]);

        $json->registerDataSource('user_function', function ($json, $config = []) {
            return [
                'id' => 3,
                'name' => 'Hello user_function',
                "data_option" => $config['_data_option'] ?? [],
                // 'post' => $json->getAsyncJson([
                //     "_data_source" => "post"
                // ])
            ];
        });

        $json->registerDataSource('user_function_quote', [
            "_data_source" => "user_function",
            "_data_context" => [
                "id" => ":id",
                "default" => 1
            ],
            "_data_option" => "user_option",
        ]);

        $json->registerDataOption('user_option', [
            "user_id" => ':id',
            "default_user_id" => 1
        ]);

        $json->registerDataStructure('user', [
            'id' => ":id",
            'name' => ':name',
        ]);

        $json->registerDataStructure('user_structure', [
            'id' => [
                "_data_structure" => "id",
            ],
            'name' => [
                "_data_structure" => "name",
            ],
        ]);

        $json->registerDataStructure('post', [
            'id' => ":id",
            'name' => ':name',
        ]);

        $json->registerDataStructure('post_structure', [
            'id' => [
                "_data_structure" => "id",
            ],
            'name' => [
                "_data_structure" => "name",
            ],
        ]);

        $json->registerDataStructure("id", ":id");
        $json->registerDataStructure("name", ":name");

        echo json_encode($json->getAsyncJson([
            "user" => ':user',
            "user_1" => [
                "_data_source" => "user",
            ],
            "user_2" => [
                "_data_source" => "user",
                "_data_structure" => "user"
            ],
            "user_structure" => [
                "_data_source" => "user",
                "_data_structure" => "user_structure"
            ],
            "user_5" => [
                "_data_source" => "user",
                "_data_structure" => [
                    "id" => ":id",
                    "name" => ":name"
                ]
            ],
            
            "user_id" => ":user.id",
            "user_function" => ':user_function',
            "user_option" => [
                "_data_source" => "user",
                "_data_structure" => [
                    "id" => ":id",
                    "name" => ":name",
                    "post" => [
                        "_data_source" => "user_function",
                        "_data_option" => "user_option",
                    ]
                ]

            ],
            "user_overwrite_option" => [
                "_data_source" => 'user',
                "_data_structure" => [
                    "id" => ":id",
                    "name" => ":name",
                    "post" => [
                        "_data_source" => "user_function",
                        "_data_option" => "user_option",
                        "_data_context" => [
                            "id" => "10"
                        ]
                    ]
                ]

            ],
            "user_function_quote" => [
                "_data_source" => 'user_function_quote',
                "_data_context" => [
                    "id" => "10"
                ],
            ],


            "post" => [
                "_data_source" => "post",
                "_data_structure" => "post"
            ],
            "post_structure" => [
                "_data_source" => "post",
                "_data_structure" => "post_structure"
            ],
            "post2" => [
                "_data_source" => "post",
                "_data_structure" => [
                    "id" => ":id",
                    "name" => ":name"
                ]
            ],
            "user_post" => ":user_post",
            "user_post" => [
                "_data_source" => "user_post",
                "_data_structure" => [
                    "id" => ":id",
                    "name" => ":name",
                    "post" => [
                        "_data_source" => ":post",
                        "_data_structure" => [
                            "id" => ":id",
                            "user_function_quote" => [
                                "_data_source" => 'user_function_quote',
                                "_data_context" => [
                                    "id" => "12"
                                ],
                            ],
                        ]
                    ]
                ]
            ],
        ]));

    }

    /**
     * Provide autocomplete suggestions for the "myCustomArgument" argument
     */
    // public function suggestMyCustomArgumentValues(): array
    // {
    //     return ['value', 'another'];
    // }
}
