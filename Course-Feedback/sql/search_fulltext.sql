SELECT courseId, semester, courseType, name, outline, objective, MATCH (`outlineToken`, `objectiveToken`) AGAINST ('演算法' IN NATURAL LANGUAGE MODE) AS score
FROM course
WHERE MATCH (`outlineToken`, `objectiveToken`) AGAINST ('演算法' IN NATURAL LANGUAGE MODE) > 0.001;
