<?php
/***********Application****************/
const VERIFYBEE_API_TOKEN = "";
const OUTREACHBIN_WEBHOOK = '';

/*******Site Settings************/

//define("SITE_URL",env("APP_URL"));
// echo constant("GREETING");
// const LOCALHOST = TRUE;
// const SITE_URL = LOCALHOST ? 'http://127.0.0.1:8000' : 'https://app.outreachbin.com';

const REMEMBERME = '__rememberMe__';
const LIVE_URL = 'https://app.outreachbin.com';
const SITE_URL = 'https://app.outreachbin.com';
const SITE_NAME = 'SalesMix';
const SITE_TITLE = 'SalesMix';
const SITE_TAG = 'SalesMix Tags';
const SITE_KEYWORDS = 'SalesMix';

const GOOGLE_AUTH_KEY = '';
//const RECAPTCHA_ID = '';
const RECAPTCHA_ID = '';

/******Stripe Tables***********/
const STRIPE_TRIALS_DAYS = 7;
const STRIPE_LIVE = FALSE;
const STRIPE_KEY = "";
const STRIPE_SECRET = "";
const STRIPE_KEY_TEST = "";
const STRIPE_SECRET_TEST = "";
//const UNLIMITED_PLAN_ID = ";
const UNLIMITED_PLAN_ID = "";
//const UNLIMITED_PLAN_ID = ";

/******Elastic Tables***********/
const TBL_USER = 'users';
const TBL_WORKSPACE = 'workspaces';
const TBL_WORKSPACE_USER = 'workspace_users';
const TBL_WORKSPACE_INVITATION = 'workspace_invitations';
const TBL_PROSPECT_LIST = 'prospect_lists';
const TBL_PROSPECT = 'prospects';
const TBL_SEQUENCE = 'sequences';
const TBL_SEQUENCE_LOGS = 'sequence_logs';
const TBL_SEQUENCE_PROSPECT_MAPPING = 'sequence_prospect_map';
const TBL_WARM_UP = 'warm_ups';
const TBL_CAMPAIGN_CHANGES = 'campaigns_changes';
const TBL_MESSAGES = 'messages';
const TBL_SIGNATURES = 'signatures';
const TBL_TEMPLATES = 'templates';
const TBL_EMAIL_PROVIDERS = 'email_providers';
const TBL_SUBSCRIPTIONS = 'subscriptions';
const TBL_UNLOCK_LOGS = 'unlock_logs';
const TBL_LEAD_LISTS = 'lead_lists';
const TBL_LEAD_LIST_UPLOADS = 'lead_list_uploads';
const TBL_INBOX = 'inboxes';
const TBL_READ_INBOX_LOGS = 'read_inbox_logs';
const TBL_WARM_UP_LOGS = 'warm_up_logs';
const TBL_CAMPAIGN_LOGS = 'campaign_logs';
const TBL_CUSTOM_DOMAINS = 'custom_domains';
const TBL_VERIFY_LOGS = 'verify_logs';
const TBL_ANALYTICS = 'analytics';
const TBL_GRAVEYARD_LIST = 'graveyard_lists';
const TBL_NOTIFICATIONS = 'notifications';
const TBL_PROSPECT_NOTES = 'prospect_notes';
const TBL_PROSPECT_TASKS = 'prospect_tasks';

/******User Type***********/
const USER_TYPE_USER = 'user';
const USER_TYPE_ADMIN = 'admin';
const USER_TYPE_MEMBER = 'member';
const USER_TYPE_CLIENT = 'client';

/******end Elastic Tables***********/
const CUSTOM_VARIABLE = ['first_name','last_name', 'email', 'phone', 'website', 'company', 'position', 'linkedin_url'];

/*****************End of Subscriber Table Information*************/
/*****************sequence Table Information*************/
const SEQUENCE_STATUS_DRAFT = 'draft';
const SEQUENCE_STATUS_ARCHIVED = 'archived';
const SEQUENCE_STATUS_RUNNING = 'running';
const SEQUENCE_STATUS_PAUSED = 'paused';
const SEQUENCE_STATUS_COMPLETED = 'completed';

/*****************end of sequence Table Information*************/
const CAMP_FOLLOWUP_EMAIL = 'email';
const CAMP_FOLLOWUP_SCHEDULE_CALL = 'schedule_call';
const CAMP_FOLLOWUP_LINKEDIN = 'linkedin';
const CAMP_FOLLOWUP_TASK = 'task';

const nType_profile = 'Profile';
const nType_subscription = 'Subscriptions';
const nType_sequence = 'Sequence';
const nType_email = 'Email';

/*****************End of Campaign Table Information*************/

/*********************When Replied in Sequence*******************/
const WHEN_REPLY_FINISHED = 'finished';
const WHEN_REPLY_CONTINUE = 'continue';
/********************End of When Replied in Sequence*************/

/*********************Followup Condition in Sequence*******************/
const FOLLOWUP_DELAY = 'delay';
const FOLLOWUP_OPEN = 'open';
const FOLLOWUP_REPLY = 'reply';
/********************End of Followup Condition in Sequence*************/
