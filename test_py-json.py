import json

with open('test.json') as data_file:    
    data = json.load(data_file)


with open('config.json') as data_file:    
    config = json.load(data_file)
print config
