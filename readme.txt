Link to Login as User. Pass the user account as argument.

<f:link.action action="loginAsUser" controller="Login" package="Lelesys.SuperUser" arguments="{account: account}">Login as User</f:link.action>

--------------------------------------------------------------------------------

Policy should be like

For Older version of Flow

roles:
  Administrator: [SuperUser]


For Newer version of Flow

roles:
  Administrator: [Lelesys.SuperUser:SuperUser]

--------------------------------------------------------------------------------

Settings to redirect super user if login is successful or failed and after logout as user.

Lelesys:
  SuperUser:
    superUserRedirectOptions:
      loginAsUserFailed:
        package: 'My.Admin'
        controller: 'Admin'
        action: 'index'
      loginAsUserSuccess:
        package: 'My.User'
        controller: 'User'
        action: 'index'
      logoutAsUser:
        package: 'My.Admin'
        controller: 'Admin'
        action: 'index'

