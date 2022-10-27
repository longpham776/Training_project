SELECT maker.model_maker_hyouji, v2.model_maker_code, model_image_url, v2.model_hyouji, model_code
,case
	when (model_kakaku_min IS NULL OR model_kakaku_min = '') then '0'
	ELSE Trim(Round(model_kakaku_min/10000,2))+0
END
AS model_kakaku_min
,case
	when (model_kakaku_max IS NULL OR model_kakaku_max = '') then '0'
	ELSE Trim(Round(model_kakaku_max/10000,2))+0
END
AS model_kakaku_max
, model_count AS motorcycle_count
FROM mst_model_v2 AS v2
INNER JOIN mst_model_maker AS maker ON v2.model_maker_code = maker.model_maker_code
WHERE model_count > 0
AND model_genchari = 1
AND model_kana_prefix = 'ハ'
AND model_name_prefix = 'B'
AND model_motortype_code = 0
AND (model_displacement >= 0 AND model_displacement <=50)

