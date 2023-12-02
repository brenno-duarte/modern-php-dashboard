<?php

namespace Dashboard\Form;

use Dashboard\Database\Database;
use Dashboard\HelpersTrait;
use Dashboard\Template\Template;

class Form
{
    use HelpersTrait;

    private static array $db_results;
    private array $input = [];
    private string $button_submit = '';
    private static string $html;
    private static string $form_type;
    private static array $columns_database;

    /* public function __construct() {
        /* $reflection = new \ReflectionProperty($this->redirect, 'url');
        $action = $reflection->getValue($this->redirect);

        self::$html = Template::getTemplate('form/form.php', [
            'action' => $action,
            'method' => $this->form_type->value
        ]); 
    } */

    public static function create(FormMethodEnum $form_type, object $redirect): static
    {
        $reflection = new \ReflectionProperty($redirect, 'url');
        $action = $reflection->getValue($redirect);
        self::$form_type = "create";

        self::$html = Template::getTemplate('form/form.php', [
            'action' => $action,
            'method' => $form_type->value
        ]);

        return new static;
    }

    public static function edit(string $id_table, FormMethodEnum $form_type, object $redirect): static
    {
        $reflection = new \ReflectionProperty($redirect, 'url');
        $action = $reflection->getValue($redirect);
        self::$form_type = "edit";

        self::$html = Template::getTemplate('form/form-edit.php', [
            'action' => $action,
            'method' => $form_type->value,
            'id_value' => $id_table
        ]);

        return new static;
    }

    public function input(string $label_name, string $input_type, string $name, string $id = '', string $value = '', array $options = [])
    {
        $this->input[] = [
            'label' => $label_name,
            'type' => $input_type,
            'name' => $name,
            'id' => $id,
            'value' => $value,
            'options' => $options
        ];

        return $this;
    }

    public function submitButton(string $name = 'Send')
    {
        $this->button_submit = Template::getTemplate('form/button.php', [
            'name' => $name
        ]);

        return $this;
    }

    public static function createDataTable(array $data, array $columns)
    {
        self::$form_type = "table";
        self::$db_results = $data;
        //self::$db_results = Database::get($table);
        self::$columns_database = $columns;

        return new static;
    }

    public function render()
    {
        switch (self::$form_type) {
            case 'create':
                self::$html .= $this->renderForm();
                break;

            case 'edit':
                self::$html .= $this->renderForm();
                break;

            case 'table':
                self::$html = $this->renderTable();
                break;
        }

        echo self::$html;
    }

    private function renderForm(): string
    {
        $html = "";

        foreach ($this->input as $key => $input_value) {
            if ($this->input[$key]['type'] == "checkbox" || $this->input[$key]['type'] == "radio") {
                $view = "check";
            } else {
                $view = "input";
            }

            $html .= Template::getTemplate("form/" . $view . ".php", [
                'name' => ($input_value['name'] != '' ? 'name="' . $input_value['name'] . '"' : ''),
                'for' => $input_value['id'] != '' ? ' for="' . $input_value['id'] . '" ' : '',
                'label' => $input_value['label'],
                'type' => $input_value['type'],
                'value' => ($input_value['value'] != '' ? 'value="' . $input_value['value'] . '"' : ''),
                'id' => ($input_value['id'] != '' ? 'id="' . $input_value['id'] . '"' : ''),
                'options' => (!empty($input_value['options']) ? implode(" ", $input_value['options']) : '')
            ]);
        }

        $html .= $this->button_submit;
        $html .= "</form>
            </div>
        </div>";

        return $html;
    }

    private function renderTable()
    {
        $table_tr_html = "<tr>\n";
        $table_results_html = "";

        foreach (self::$columns_database as $column) {
            if (str_contains("id", $column)) {
                $column = str_replace($column, "#", $column);
            }

            $table_tr_html .= "<th scope='col'>" . $column . "</th>\n";
        }

        $table_tr_html .= "<th scope='col'>Edit</th>";

        foreach (self::$db_results as $db_results) {
            $db_results = (array)$db_results;
            $table_results_html .= "<tr>\n";

            foreach (self::$columns_database as $key => $column) {
                $value = $db_results[self::$columns_database[$key]];

                if (self::passwordIsHash($value)) {
                    $value = str_replace($value, '*****', $value);
                }

                $table_results_html .= "<td>" . $value . "</td>\n";
            }

            //" . Template::route("delete/" . $db_results['id']) . "

            $table_results_html .= "<th scope='col'>
                <a href='" . Template::route("edit/" . $db_results['id']) . "' class='btn btn-outline-warning'><i class='bi bi-pencil-square'></i></a>
                <a href='" . Template::route("delete/" . $db_results['id']) . "' class='btn btn-outline-danger' onclick='return confirm(\"Are you sure you want to Remove?\");'><i class='bi bi-trash'></i></a>
            </th>";

            $table_results_html .= "</tr>\n";
        }

        $table_tr_html .= "</tr>\n";

        return Template::renderTemplate("table.php", [
            "table_tr" => $table_tr_html,
            "table_results" => $table_results_html
        ]);
    }
}
