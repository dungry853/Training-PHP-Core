<?php

namespace App\Core;

use DateTime;

class Validator
{
    protected array $errors = [];

    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];

        foreach ($rules as $field => $rulesString) {
            $rulesArray = explode('|', $rulesString);
            foreach ($rulesArray as $rule) {
                $ruleName = $rule;
                $ruleValue = null;

                // Nếu rule có tham số, ví dụ: min:6
                // strpos() — Tìm vị trí của chuỗi con trong chuỗi mẹ
                // Hàm list() trong PHP được dùng để gán các phần tử của một mảng vào các biến riêng lẻ. Nó thường đi kèm với explode() hoặc các hàm trả về mảng.
                // explode() — Tách chuỗi thành mảng dựa trên ký tự phân tách
                // Nếu rule có dạng 'min:6', ta tách thành 'min' và '6'
                // $data = ['Dung', 22, 'HCM'];
                //list($name, $age, $city) = $data;
                //echo $name; // Dung
                //echo $age;  // 22
                //echo $city; // HCM
                if (strpos($rule, ':') !== false) {
                    list($ruleName, $ruleValue) = explode(':', $rule);
                }

                $value = $data[$field] ?? null;

                // Thực hiện kiểm tra theo rule
                switch ($ruleName) {
                    case 'required':
                        if (empty($value)) {
                            $this->addError($field, "$field không được để trống");
                        }
                        break;

                    case 'UsernameOrEmail':

                        if (strpos($value, '@') !== false) {
                            // Nếu có ký tự '@', coi là email
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $this->addError($field, "$field không đúng định dạng email");
                            }
                        }
                        break;

                    case 'min':
                        if (strlen($value) < (int)$ruleValue) {
                            $this->addError($field, "$field phải có ít nhất $ruleValue ký tự");
                        }
                        break;

                    case 'max':
                        if (strlen($value) > (int)$ruleValue) {
                            $this->addError($field, "$field không được vượt quá $ruleValue ký tự");
                        }
                        break;
                    case 'same':
                        if ($value !== ($data[$ruleValue] ?? null)) {
                            $this->addError($field, "$field phải giống với $ruleValue");
                        }
                        break;

                    case 'date_format':
                        $dateFormat = 'Y-m-d'; // Định dạng ngày mặc định
                        if ($ruleValue) {
                            $dateFormat = $ruleValue; // Nếu có định dạng cụ thể
                        }

                        $d = DateTime::createFromFormat($dateFormat, $value);
                        if (!$d || $d->format($dateFormat) !== $value) {
                            $this->addError($field, "$field phải có định dạng ngày tháng là $dateFormat");
                        }
                        break;

                        // Bạn có thể thêm rule khác ở đây
                }
            }
        }

        return empty($this->errors);
    }

    protected function addError(string $field, string $message)
    {
        $this->errors[$field][] = $message;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
