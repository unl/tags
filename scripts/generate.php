<?php
/**
 * TAG ALL THE THINGS
 *
 * This script generates a list of tags and details associated with those tags
 */

use UNL\Tags\Tag;

require __DIR__ . '/../vendor/autoload.php';

$tags = [];

//root tag
$tags['unl'] = new Tag('unl', 'University of Nebraska–Lincoln');

/**
 * Audiences, can tag content that pertains to these audiences
 */
$tags['audiences'] = new Tag('audiences', 'Audiences');
$tags['unl']->addChild($tags['audiences']);

$audiences = [
    'students' => 'Students',
    'faculty' => 'Faculty',
    'staff' => 'Staff',
    'perspective_student' => 'Perspective Student',
    'parents' => 'Parents',
    'emeriti' => 'Emeriti',
    'visitors' => 'Visitors',
    'undergraduate_students' => 'Undergraduate Students',
    'graduate_students' => 'Graduate Students',
    'transfer_students' => 'Transfer Students',
    'alumni' => 'Alumni'
];

foreach ($audiences as $machineName => $humanName) {
    $tags[$machineName] = new Tag($machineName, $humanName);
    $tags['audiences']->addChild($tags[$machineName]);
}

/**
 * General
 * 
 * General tags that don't exactly fit anywhere else
 */
$general = [
    'sports' => 'Sports',
    'jobs' => 'Jobs',
    'research' => 'Research',
    'internships' => 'Internships',
    'club' => 'Club',
    'event' => 'Event',
];

foreach ($general as $machineName => $humanName) {
    $tags[$machineName] = new Tag($machineName, $humanName);
    $tags['unl']->addChild($tags[$machineName]);
}

/**
 * Add tags for each college
 * Retrieved from https://catalog.unl.edu/undergraduate/
 */
$tags['colleges'] = new Tag('colleges', 'Colleges');
$tags['unl']->addChild($tags['colleges']);

$colleges = [
    'casnr' => 'Agricultural Sciences & Natural Resources',
    'architecture' => 'Architecture',
    'arts_sciences' => 'Arts & Sciences',
    'cob' => 'College of Business',
    'education_human_sciences' => 'Education & Human Sciences',
    'engineering' => 'Engineering',
    'fine_arts' => 'Fine & Performing Arts',
    'journalism' => 'Journalism & Mass Communications',
];

foreach ($colleges as $machineName => $humanName) {
    $tags[$machineName] = new Tag($machineName, $humanName);
    $tags['colleges']->addChild($tags[$machineName]);
}


/**
 * Add tags for each business area of study
 * Retrieved from https://catalog.unl.edu/undergraduate/
 */
$tags['aos'] = new Tag('aos', 'Areas of Study');
$tags['unl']->addChild($tags['aos']);

$business_areas = [
    'accounting' => 'Accounting',
    'actuarial_sciences' => 'Actuarial Science (Business)',
    'agribusiness' => 'Agribusiness (Business)',
    'administration' => 'Administration',
    'analytics' => 'Business Analytics',
    'economics' => 'Economics (Business)',
    'finance' => 'Finance',
    'global_leadership' => 'Global Leadership',
    'international_business' => 'International Business',
    'management' => 'Management',
    'marketing' => 'Marketing',
    'supply_chain_management' => 'Supply Chain Management'
];

foreach ($business_areas as $machineName=>$humanName) {
    $tags[$machineName] = new Tag($machineName, $humanName);
    $tags['cob']->addChild($tags[$machineName]);
    $tags['aos']->addChild($tags[$machineName]);
}


$buildings = json_decode(file_get_contents('http://maps.unl.edu/?view=allbuildings&format=json'));
$tags['buildings'] = new Tag('buildings', 'Buildings');
$tags['unl']->addChild($tags['buildings']);
foreach ($buildings as $machineName=>$humanName) {
    $machineName = 'building_'.$machineName;
    $tags[$machineName] = new Tag($machineName, $humanName);
    $tags['buildings']->addChild($tags[$machineName]);
}

//Now export
$unl_tree = json_encode($tags['unl'], JSON_PRETTY_PRINT);
file_put_contents(__DIR__ . '/../data/unl_tree.json', $unl_tree);

$flat = [];
foreach($tags as $tag) {
    $flat[$tag->getMachineName()] = $tag->getHumanName();
}

file_put_contents(__DIR__ . '/../data/flat.json', json_encode($flat, JSON_PRETTY_PRINT));
