UPDATE license_types
SET name = :name, description = :description, doc_url = :doc_url, monthly_price = :monthly_price, currency = :currency
WHERE license_type_id = :license_type_id;