def get_number(prompt):
    while True:
        try:
            return float(input(prompt))
        except ValueError:
            print("Ошибка: введите число")

def add(a, b):
    return a + b

def subtract(a, b):
    return a - b
def multiply(a, b):
    return a * b
def divide(a, b):
    if b != 0:
        return a / b
    else:
        return "Ошибка: деление на ноль"
# Основная программа
print("Простой калькулятор")
print("Доступные операции: +, -, *, /")
