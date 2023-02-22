<?php

use Illuminate\Database\Eloquent\Collection;

if (!function_exists('getValueOrDefault')) {
    /**
     * Return `$default` if `$value` is null or empty or not in `$constraints`
     *
     * @param string|null $value value to find
     * @param array $constraints array to match with $value
     * @param string $default default value if the $value is not match
     * @return string
     */
    function getValueOrDefault(string|null $value, array $constraints, string $default): string
    {
        return $value
            ? (array_search($value, $constraints) >= 0 ? $value : $default)
            : $default;
    }
}

if (!function_exists('convertToSelectOptions')) {
    /**
     * Convert data array to frontend component select options
     *
     * @param Collection|array $collection
     * @param string|null $column_value
     * @param string|array|null $column_label
     * @return array
     */
    function convertToSelectOptions(Collection|array $collection, ?string $column_value = null, string|array|null $column_label = null): array
    {
        if (is_array($collection)) {
            $collection = collect($collection);
        }

        return $collection
            ->map(function ($datum) use ($column_value, $column_label) {
                $label = "";
                if (isset($column_label)) {
                    if (is_array($column_label)) {
                        foreach ($column_label as $item) {
                            $label .= next($column_label) ? "{$datum[$item]} - " : $datum[$item];
                        }
                    } else {
                        $label = $datum[$column_label];
                    }
                } else {
                    $label = $datum;
                }

                return [
                    'value' => isset($column_value) ? $datum[$column_value] : $datum,
                    'label' => $label,
                ];
            })
            ->toArray();
    }
}