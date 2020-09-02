# CentOS

## 网络不同的问题

### /etc/sysconfig/network-scripts/ifcfg-e? 配置

	DEVICE=eth0
	TYPE=Ethernet
	ONBOOT=yes
	NM_CONTROLLED=yes
	BOOTPROTO=none
	HWADDR=00:0C:29:6d:95:46
	IPADDR=192.168.0.240
	NETMASK=255.255.255.0
	GATEWAY=192.168.0.1
	DNS1=202.96.134.166
	PREFIX=24
	DEFROUTE=yes
	IPV4_FAILURE_FATAL=yes
	IPV6INIT=no
	NAME="System eth0"
### /etc/udev/rules.d/70-persistent-net.rules 检查mac addresss 是否一致

