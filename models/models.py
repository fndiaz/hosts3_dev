Cliente = db.define_table("cliente",
      Field("nome", notnull=True, unique=True),
      Field("email"),
      Field("gtalk"),
      #auth.signature
      migrate=False,
      format="%(nome)s")

Servidor = db.define_table("servidor",
      Field("nome", notnull=True),
      migrate=False,
      format="%(nome)s")

Distro = db.define_table("distro",
      Field("nome", notnull=True),
      Field("img", notnull=True),
      Field("imagem", notnull=True),
      migrate=False,
      format="%(nome)s")

if request.is_local:
      uploadfolder='/home/fernando/web2py/applications/projeto/static/arq'
else:
      uploadfolder='/var/www/hosts3/applications/projeto/static/arq'

Hosts = db.define_table("hosts",
      Field("id_cliente", db.cliente),
      Field("id_servidor", db.servidor),
      Field("id_distro", db.distro),
      Field("servicos", "text"),
      Field("if1"),
      Field("ip1"),
      Field("masc1"),
      Field("obs1"),
      Field("if2"),
      Field("ip2"),
      Field("masc2"),
      Field("obs2"),
      Field("if3"),
      Field("ip3"),
      Field("masc3"),
      Field("obs3"),
      Field("if4"),
      Field("ip4"),
      Field("masc4"),
      Field("obs4"),
      Field("nome", notnull=True),
      Field("ip_chegada", notnull=True),
      Field("porta_ssh", notnull=True),
      Field("gateway", notnull=True),
      Field("rotas", "text"),
      Field("obs_gerais", "text"),
      Field("upload", "upload", uploadfolder=uploadfolder, autodelete=True),
      Field("upload2", "upload", uploadfolder=uploadfolder, autodelete=True),
      Field("upload3", "upload", uploadfolder=uploadfolder, autodelete=True),
      migrate=False,
      format="%(nome)s")

Interface = db.define_table("interface",
      Field("id_hosts", db.hosts),
      Field("nome"),
      Field("ip"),
      migrate=False,
      format="%(nome)s")


if db(db.auth_group.role == 'admin').isempty():
      db.auth_group.insert(role="admin")

if db(db.auth_user.email == 'fernando@forip.com.br').isempty():
      ##Inserindo user root
      root = db.auth_user.insert(first_name="fernando",last_name="root",\
      email="fernando@forip.com.br",\
      password=db.auth_user.password.validate("root123")[0])
      ##Inserindo permissão de administrador
      group_admin = db(db.auth_group.role == 'admin').select()
      auth.add_membership(group_admin[0].id, root)