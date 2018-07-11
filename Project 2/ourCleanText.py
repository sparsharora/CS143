#!/usr/bin/env python

"""Clean comment text for easier parsing."""

from __future__ import print_function

import re
import string
import argparse


__author__ = ""
__email__ = ""

# Some useful data.
_CONTRACTIONS = {
    "tis": "'tis",
    "aint": "ain't",
    "amnt": "amn't",
    "arent": "aren't",
    "cant": "can't",
    "couldve": "could've",
    "couldnt": "couldn't",
    "didnt": "didn't",
    "doesnt": "doesn't",
    "dont": "don't",
    "hadnt": "hadn't",
    "hasnt": "hasn't",
    "havent": "haven't",
    "hed": "he'd",
    "hell": "he'll",
    "hes": "he's",
    "howd": "how'd",
    "howll": "how'll",
    "hows": "how's",
    "id": "i'd",
    "ill": "i'll",
    "im": "i'm",
    "ive": "i've",
    "isnt": "isn't",
    "itd": "it'd",
    "itll": "it'll",
    "its": "it's",
    "mightnt": "mightn't",
    "mightve": "might've",
    "mustnt": "mustn't",
    "mustve": "must've",
    "neednt": "needn't",
    "oclock": "o'clock",
    "ol": "'ol",
    "oughtnt": "oughtn't",
    "shant": "shan't",
    "shed": "she'd",
    "shell": "she'll",
    "shes": "she's",
    "shouldve": "should've",
    "shouldnt": "shouldn't",
    "somebodys": "somebody's",
    "someones": "someone's",
    "somethings": "something's",
    "thatll": "that'll",
    "thats": "that's",
    "thatd": "that'd",
    "thered": "there'd",
    "therere": "there're",
    "theres": "there's",
    "theyd": "they'd",
    "theyll": "they'll",
    "theyre": "they're",
    "theyve": "they've",
    "wasnt": "wasn't",
    "wed": "we'd",
    "wedve": "wed've",
    "well": "we'll",
    "were": "we're",
    "weve": "we've",
    "werent": "weren't",
    "whatd": "what'd",
    "whatll": "what'll",
    "whatre": "what're",
    "whats": "what's",
    "whatve": "what've",
    "whens": "when's",
    "whered": "where'd",
    "wheres": "where's",
    "whereve": "where've",
    "whod": "who'd",
    "whodve": "whod've",
    "wholl": "who'll",
    "whore": "who're",
    "whos": "who's",
    "whove": "who've",
    "whyd": "why'd",
    "whyre": "why're",
    "whys": "why's",
    "wont": "won't",
    "wouldve": "would've",
    "wouldnt": "wouldn't",
    "yall": "y'all",
    "youd": "you'd",
    "youll": "you'll",
    "youre": "you're",
    "youve": "you've"
}

# You may need to write regular expressions.

def sanitize(text):
    """Do parse the text in variable "text" according to the spec, and return
    a LIST containing FOUR strings
    1. The parsed text.
    2. The unigrams
    3. The bigrams
    4. The trigrams
    """
    #initialize all return values to empty strings
    parsed_text = ""
    unigrams = ""
    bigrams = ""
    trigrams = ""

    #Replace newlines and tabspaces with a single space

    parsed_text = " ".join(text.split())
    #= text.replace('\n', ' ').replace('\t', '')

    #print(parsed_text)

    #parsed_text = re.sub(r"\[.*\](https?:\/\/\S+)", "hi", parsed_text)
    parsed_text = re.sub(r"https?:\/\/\S+", "", parsed_text)

    #parsed_text = re.sub(r"http\S+", "", parsed_text)

    #print(parsed_text)

    # Point 4:

    pattern = re.compile(r"([.?!,;:])")
    s = pattern.sub(" \\1 ", parsed_text)
    #s = re.sub(r"([\w']+|([\w\-]+)|[.,!?;])", r' \1 ', parsed_text)
    #s = re.sub(r"([\w']+|[.,!?;])", r' \1 ', parsed_text)
    s = re.sub('\s{2,}', ' ', s).lstrip()
    #print(s)

    #Point 5:

    words = s.split()
    lst = {'.', '!', '?', ',', ';', ':'}
    ##print(lst[0].isalnum())

    flag=0
    for index, temp in enumerate(words):
        temp = words[index]
        length = len(temp)
        for i,char in enumerate(temp):
            if(flag==-1):
                i=i-1
                flag=0
            if char in lst:
                 break
            elif (char.isalnum()==False):
                if (i==0):
                    temp=temp[1:]
                    flag=-1
                elif(i==length-1):
                    temp=temp[:-1]
                    break;
                elif((temp[i-1].isalnum()==False) or (temp[i+1].isalnum()==False)):
                        temp = temp[:i] + temp[i+1:]
        words[index] = temp


    # Point 6:

    words = " ".join(words)
    s = words.lower()
    unigrams = s
    #print(s)

    #Point 7:

    unigrams = unigrams.split()
    for indi,temp in enumerate(unigrams):
        temp = unigrams[indi]
        #for j,chars in enumerate(temp):
        if (temp in lst and len(temp)==1):
            #print(temp+'Here')
            temp=temp[1:]
            unigrams[indi] = temp

    unigrams = " ".join(unigrams)
    unigrams = re.sub('\s{2,}', ' ', unigrams).lstrip()
    #print(unigrams)

    #Point 8:
    fakeBigram = ""
    bigrams = s
    bigrams = re.split('[.!?,:;]',bigrams)
    #print(bigrams[:500])

    for indice,tempGram in enumerate(bigrams):
        tempGram = bigrams[indice]
        tempGram = tempGram.split()

        if(len(tempGram) > 1):
            for ind,tempWord in enumerate(tempGram):
                tempWord = tempGram[ind]
                if(ind < len(tempGram)-1):
                    fakeBigram+=tempWord+"_"+tempGram[ind+1]+" "

    bigrams = fakeBigram
    #print(bigrams)

    #Point 9:

    fakeTrigram = ""
    trigrams = s
    trigrams = re.split('[.!?,:;]',trigrams)
    #print(trigrams[:500])

    for indice,tempGram in enumerate(trigrams):
        tempGram = trigrams[indice]
        tempGram = tempGram.split()

        if(len(tempGram) > 2):
            for ind,tempWord in enumerate(tempGram):
                tempWord = tempGram[ind]
                if(ind < len(tempGram)-2):
                    fakeTrigram+=tempWord+"_"+tempGram[ind+1]+"_"+tempGram[ind+2]+" "

    trigrams = fakeTrigram
    #print(trigrams)


    return [parsed_text, unigrams, bigrams, trigrams]


if __name__ == "__main__":
    # This is the Python main function.
    # You should be able to run
    # python cleantext.py <filename>
    # and this "main" function will open the file,
    # read it line by line, extract the proper value from the JSON,
    # pass to "sanitize" and #print the result as a list.

    # YOUR CODE GOES BELOW.
    #print("hello")
    lst = sanitize("I'm afraid I can't explain myself, sir. Because I am not myself, you see?")
    
    #print(lst[:500])
