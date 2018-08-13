<?php
namespace MyPlugin;

defined('ABSPATH') or die(__('You shall not pass!', 'my-plugin-text'));

class Example_Model {

    public $id = 0;
    public $int_column = 0;
    public $text_column = '';
    public $bool_column = false;
    public $created_at = '';
    public $updated_at = '';

    /**
     * Gets all models from the database;
     * @return array
     */
    public static function all() {
        global $wpdb;
        $table = $wpdb->prefix . \MyPlugin\Database::NAME_OF_TABLE;
        $rows = $wpdb->get_results("SELECT * FROM $table");
        if (empty($rows)) {
            return new \WP_Error(
                'model_error',
                __('No models have been saved', 'my-plugin-text'),
                ['status' => '404']
            );
        }
        $models = [];
        foreach ($rows as $row) {
            $models[] = self::create_from_database($row);
        }
        return $models;
    }

    private static function create_from_database($row) {
        $model = new self();
        $model->id = (int) $row->id;
        $model->int_column = (int) $row->int_column;
        $model->text_column = stripslashes($row->text_column);
        $model->bool_column = $row->bool_column == 1;
        $model->created_at = $row->created_at;
        $model->updated_at = $row->updated_at;
        return $model;
    }

    /**
     * Finds a single model in the database.
     * @param  int $id Model ID.
     * @return object
     */
    public static function find($id) {
        global $wpdb;
        $table = $wpdb->prefix . \MyPlugin\Database::NAME_OF_TABLE;
        $row = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table
            WHERE id = %d",
            $id
        ));
        if (is_null($row)) {
            return new \WP_Error(
                'model_error',
                __('Model could not be found', 'my-plugin-text'),
                ['status' => '404']
            );
        }
        return self::create_from_database($row);
    }

    /**
     * Saves a model to the database.
     *
     * If the model is new and has no id, it will insert the model data into the database.
     * Otherwise, it will update the existing model based on the model's `id`.
     *
     * @return bool|int     If the save fails, `false` will be returned. If it succeeds, the `id`
     *                      will be returned
     */
    public function save() {
        $success = ($this->id == 0) ? $this->create_new_model() : $this->update_model();
        if ($success === false) {
            return false;
        }
        return $this->id;
    }

    private function create_new_model() {
        global $wpdb;
        $success = $wpdb->insert(
            $wpdb->prefix . \MyPlugin\Database::NAME_OF_TABLE,
            $this->format_data_for_saving(),
            $this->database_formats()
        );
        if ($success) {
            $this->id = $wpdb->insert_id;
        }
        return $success;
    }

    private function format_data_for_saving() {
        return [
            'int_column' => (int) $this->int_column,
            'text_column' => $this->text_column,
            'bool_column' => $this->bool_column ? 1 : 0,
        ];
    }

    // This must match the array order of the format_data_for_saving method
    private function database_formats() {
        return ['%d', '%s', '%d'];
    }

    private function update_model() {
        global $wpdb;
        return $wpdb->update(
            $wpdb->prefix . \MyPlugin\Database::NAME_OF_TABLE,
            $this->format_data_for_saving(),
            ['id' => $this->id],
            $this->database_formats(),
            ['%d']
        );
    }

    /**
     * Deletes a model from the database.
     * @return bool
     */
    public function delete() {
        global $wpdb;
        return $wpdb->delete(
            $wpdb->prefix . \MyPlugin\Database::NAME_OF_TABLE,
            ['id' => $this->id],
            ['%d']
        );
    }
}
