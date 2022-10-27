SELECT todouhuken_code, todouhuken_name, todouhuken_area_code, area_name
,case 
	when (total_moto IS NULL) then '0'
	ELSE total_moto
END 
as cnt
FROM mst_todouhuken todou
JOIN mst_area are ON todou.todouhuken_area_code = are.area_code
LEFT JOIN (
	SELECT dealer_todouhuken_code, COUNT(dealer_todouhuken_code) AS total_moto
	FROM mst_todouhuken todou, search_motorcycle search, mst_model_v2 model
	WHERE (search.dealer_todouhuken_code = todou.todouhuken_code AND search.motorcycle_model_code = model.model_code)
	AND motorcycle_jyoukyo = 1 OR motorcycle_jyoukyo = 5 OR motorcycle_jyoukyo = 6
	AND model_maker_code = 4
	AND dealer_todouhuken_code > 0
	GROUP BY dealer_todouhuken_code
) AS moto ON moto.dealer_todouhuken_code = todou.todouhuken_code

