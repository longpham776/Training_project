SELECT model_code, model_hyouji, model_name_prefix, model_kana_prefix
,case 
	WHEN (LEFT(model_hyouji, 1) REGEXP '[0-9]') THEN '0'
	WHEN (LEFT(model_hyouji, 1) REGEXP '[a-zA-Z]') THEN '1'
	ELSE '2'
END
AS prefix
, model_count 
FROM mst_model_v2
WHERE model_maker_code = 1 
AND (model_displacement >= 51 AND model_displacement <= 125)
ORDER BY prefix, model_hyouji, model_kana_prefix ASC