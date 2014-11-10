 ##Cliente
Cliente.nome.requires =IS_NOT_EMPTY(error_message=
						T("valor não pode ser nulo"))
#Cliente.email.requires =IS_NOT_EMPTY(error_message=
#						T("valor não pode ser nulo"))
#Cliente.email.requires =IS_EMAIL(error_message=
#						T("formato de e-mail inválido"))

##Servidor
Servidor.nome.requires =IS_NOT_EMPTY(error_message=
						T("valor não pode ser nulo"))

##Distro
Distro.nome.requires =IS_NOT_EMPTY(error_message=
						T("valor não pode ser nulo"))
Distro.imagem.requires =IS_NOT_EMPTY(error_message=
						T("valor não pode ser nulo"))
Distro.img.requires =IS_NOT_EMPTY(error_message=
						T("valor não pode ser nulo"))

##Hosts
#Hosts.id_cliente.requires =IS_NOT_EMPTY(error_message=
#						T("valor não pode ser nulo"))
#Hosts.id_servidor.requires =IS_NOT_EMPTY(error_message=
#						T("valor não pode ser nulo"))
#Hosts.id_distro.requires =IS_NOT_IN_DB(error_message=
#						T("valor não pode ser nulo"))
Hosts.nome.requires =IS_NOT_EMPTY(error_message=
						T("valor não pode ser nulo"))
Hosts.ip_chegada.requires =IS_NOT_EMPTY(error_message=
						T("valor não pode ser nulo"))
Hosts.porta_ssh.requires =IS_NOT_EMPTY(error_message=
						T("valor não pode ser nulo"))
Hosts.gateway.requires =IS_NOT_EMPTY(error_message=
						T("valor não pode ser nulo"))

