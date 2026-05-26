#!/bin/bash
# Генерация сертификатов для GRE over IPsec (strongSwan)

set -e

GREEN='[0;32m'
RED='[0;31m'
NC='[0m'

info(){
    echo -e "${GREEN}[INFO]${NC} $1"
}

error(){
    echo -e "${RED}[ERROR]${NC} $1"
}

# Проверка root
if [[ $EUID -ne 0 ]]; then
    error "Запустите скрипт от root"
    exit 1
fi

# Проверка пакетов
if ! rpm -q strongswan >/dev/null 2>&1; then
    info "Установка strongSwan"
    apt-get update
    apt-get install -y strongswan
fi

# Создание структуры каталогов
mkdir -p /etc/strongswan/ipsec.d/{cacerts,certs,private}

info "Создание корневого CA"

read -p "Введите имя CA [VPN-CA]: " ca_name
ca_name=${ca_name:-VPN-CA}

# CA key
ipsec pki --gen --type rsa --size 4096 --outform pem \
    > /etc/strongswan/ipsec.d/private/ca-key.pem

chmod 600 /etc/strongswan/ipsec.d/private/ca-key.pem

# CA cert
ipsec pki --self --ca --lifetime 3650 \
    --in /etc/strongswan/ipsec.d/private/ca-key.pem \
    --type rsa \
    --dn "CN=$ca_name" \
    --outform pem \
    > /etc/strongswan/ipsec.d/cacerts/ca-cert.pem

info "Создание сертификата роутера"

read -p "Введите имя роутера (CN): " router_name
read -p "Введите WAN IP роутера: " router_ip

# Router private key
ipsec pki --gen --type rsa --size 4096 --outform pem \
    > /etc/strongswan/ipsec.d/private/${router_name}-key.pem

chmod 600 /etc/strongswan/ipsec.d/private/${router_name}-key.pem

# CSR + cert
ipsec pki --pub \
    --in /etc/strongswan/ipsec.d/private/${router_name}-key.pem \
    --type rsa | \
ipsec pki --issue \
    --lifetime 1825 \
    --cacert /etc/strongswan/ipsec.d/cacerts/ca-cert.pem \
    --cakey /etc/strongswan/ipsec.d/private/ca-key.pem \
    --dn "CN=$router_name" \
    --san "$router_ip" \
    --flag serverAuth \
    --flag ikeIntermediate \
    --outform pem \
    > /etc/strongswan/ipsec.d/certs/${router_name}-cert.pem

info "Сертификаты успешно созданы"

echo

echo "Файлы:"
echo "------------------------------------------"
echo "CA cert:"
echo "/etc/strongswan/ipsec.d/cacerts/ca-cert.pem"
echo

echo "Router cert:"
echo "/etc/strongswan/ipsec.d/certs/${router_name}-cert.pem"
echo

echo "Router key:"
echo "/etc/strongswan/ipsec.d/private/${router_name}-key.pem"
echo "------------------------------------------"

info "Скопируйте ca-cert.pem на обе стороны туннеля"
info "Скопируйте cert/key соответствующего роутера на нужную сторону"
