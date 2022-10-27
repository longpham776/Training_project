SELECT model_code AS modelCode, maker_code, model_name AS modelName
,case 
	when (model_displacement IS NULL) then '0'
	ELSE model_displacement
END
AS modelDisplacement
,case
	when (model_search IS NULL) then model_code
	ELSE model_search 
END
AS modelSearchKey
, maker_search AS makerSearch
FROM vw_motorcycle_v2 moto_v2, tbl_moto_type_connect moto_connect
WHERE maker_code = 1
AND moto_type_code = 2
AND moto_v2.moto_no = moto_connect.moto_type_mc_no
GROUP BY model_code
ORDER BY model_name ASC