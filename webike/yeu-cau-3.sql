SELECT model_hyouji AS motorcycle_model_name, model.model_code AS motorcycle_model_code, model_count AS motorcycle_count, model_image_url AS motorcycle_image_url
,case
	when (model_kakaku_min IS NULL OR model_kakaku_min = '') then '0'
	ELSE Trim(Round(model_kakaku_min/10000,2))+0
END
AS motorcycle_kakaku_min
,case
	when (model_kakaku_max IS NULL OR model_kakaku_max = '') then '0'
	ELSE Trim(Round(model_kakaku_max/10000,2))+0
END
AS motorcycle_kakaku_max
FROM mst_series series, mst_model_v2 model
,(SELECT * FROM mst_model_series WHERE maker_code = 9 OR maker_code = 13 OR maker_code = 37) AS model_series
WHERE series.series_code = model_series.series_code AND model.model_code = model_series.model_code
AND  model_series.series_code = 7
ORDER BY model_displacement ASC
