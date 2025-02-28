UPDATE licenses
SET name = :name, description = :description, doc_url = :doc_url, monthly_price = :monthly_price, currency = :currency
WHERE license_id = :license_id;