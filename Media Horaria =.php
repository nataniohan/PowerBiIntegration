Media Horaria = 
    VAR ST = AVERAGEX('dados (1)', SECOND('dados (1)'[diferenca]))
    VAR H = INT (ST / 3600)
    VAR M = INT( (ST - (H *3600)) / 60)
    VAR S = MOD (ST, 60)
RETURN 
H * 10000 + M * 100 + S