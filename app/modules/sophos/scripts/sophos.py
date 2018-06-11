#!/usr/bin/python

"""
Checks for Sophos installation status and various version numbers.
"""

import subprocess
import os
import sys
import re
sys.path.insert(0, '/usr/local/munki')
from munkilib import FoundationPlist


def check_sophos_running():
    cmd = ['/bin/launchctl', 'print', 'system/com.sophos.mcs']
    sp = subprocess.Popen(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    out, err = sp.communicate()

    if 'state = running' in out:
        return True
    else:
        return False


def check_sophos_versions():
    cmd = ['/usr/local/bin/sweep', '-v']
    sp = subprocess.Popen(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    out, err = sp.communicate()
    data = out.splitlines()

    version_regex = re.compile(r'(\d+\.*){1,3}')
    components = ['Product version', 'Engine version', 'Virus data version', 'User interface version']
    versions = {}
    for component in components:
        component_version = [string for string in data if component in string]
        version_number = version_regex.search(repr(component_version))
        versions.update({component: version_number.group()})

    return versions


def main():
    # Skip running on manual munki check
    if len(sys.argv) > 1:
        if sys.argv[1] == 'manualcheck':
            print 'Manual check: skipping'
            exit(0)

    # Create cache dir if it does not exist
    cachedir = '%s/cache' % os.path.dirname(os.path.realpath(__file__))
    if not os.path.exists(cachedir):
        os.makedirs(cachedir)
    
    result = {}
    # check if Sophos is installed
    if os.path.isfile('/Applications/Sophos Endpoint.app'):
        result.update({'Installed': 'True'})

    # check if Sophos is running
    result.update({'Running': check_sophos_running()})
    
    # check component versions
    result.update({'Versions': check_sophos_versions()})

    # Write results of checks to cache file
    output_plist = os.path.join(cachedir, 'sophos.plist')
    FoundationPlist.writePlist(result, output_plist)


if __name__ == "__main__":
    main()
