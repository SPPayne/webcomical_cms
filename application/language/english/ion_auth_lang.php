<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - English
*
* Author: Ben Edmunds
*         ben.edmunds@gmail.com
*         @benedmunds
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.14.2010
*
* Description:  English language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful']            = 'Account successfully created';
$lang['account_creation_unsuccessful']          = 'Error: Unable to create account';
$lang['account_creation_duplicate_email']       = 'Error: Email already used or invalid';
$lang['account_creation_duplicate_identity']    = 'Error: Identity already used or invalid';
$lang['account_creation_missing_default_group'] = 'Error: Default group is not set';
$lang['account_creation_invalid_default_group'] = 'Error: Invalid default group name set';


// Password
$lang['password_change_successful']          = 'Password successfully changed';
$lang['password_change_unsuccessful']        = 'Error: Unable to change password';
$lang['forgot_password_successful']          = 'Password reset email sent';
$lang['forgot_password_unsuccessful']        = 'Error: Unable to reset password';
$lang['forgot_password_identity_not_found']	 = 'Error: Username or email address not found!';
$lang['forgot_password_email_not_found']	 = 'Error: Email address not found!';

// Activation
$lang['activate_successful']                 = 'Account activated';
$lang['activate_unsuccessful']               = 'Error: Unable to activate account';
$lang['deactivate_successful']               = 'Account deactivated';
$lang['deactivate_unsuccessful']             = 'Error: Unable to deactivate account';
$lang['activation_email_successful']         = 'Activation email sent';
$lang['activation_email_unsuccessful']       = 'Error: Unable to send activation email';

// Login / Logout
$lang['login_successful']                    = 'Logged in successfully';
$lang['login_unsuccessful']                  = 'Error: Incorrect login';
$lang['login_unsuccessful_not_active']       = 'Error: Account is inactive';
$lang['login_timeout']                       = 'Error: Temporarily locked out. Try again later.';
$lang['logout_successful']                   = 'Logged out successfully';

// Account Changes
$lang['update_successful']                   = 'Account information successfully updated';
$lang['update_unsuccessful']                 = 'Error: Unable to update account information';
$lang['delete_successful']                   = 'User deleted';
$lang['delete_unsuccessful']                 = 'Error: Unable to delete user';

// Groups
$lang['group_creation_successful']           = 'Group created successfully';
$lang['group_already_exists']                = 'Error: Group name already taken';
$lang['group_update_successful']             = 'Group details updated';
$lang['group_delete_successful']             = 'Group deleted';
$lang['group_delete_unsuccessful']           = 'Error: Unable to delete group';
$lang['group_delete_notallowed']             = 'Error: Can\'t delete the administrators\' group';
$lang['group_name_required']                 = 'Error: Group name is a required field';
$lang['group_name_admin_not_alter']          = 'Error: Admin group name can not be changed';

// Activation Email
$lang['email_activation_subject']            = 'Account activation';
$lang['email_activate_heading']              = 'Activate account for %s';
$lang['email_activate_subheading']           = 'Please click this link to %s.';
$lang['email_activate_link']                 = 'Activate your account';

// Forgot Password Email
$lang['email_forgotten_password_subject']    = 'Forgotten password verification';
$lang['email_forgot_password_heading']       = 'Reset password for %s';
$lang['email_forgot_password_subheading']    = 'Please click this link to %s.';
$lang['email_forgot_password_link']          = 'Reset your password';

// New Password Email
$lang['email_new_password_subject']          = 'New password';
$lang['email_new_password_heading']          = 'New password for %s';
$lang['email_new_password_subheading']       = 'Your password has been reset to: %s';
